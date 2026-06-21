<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static Order create(array $attributes = [])
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    /**
     * ========================
     * RELATIONSHIPS
     * ========================
     */

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->withDefault([
                'name' => 'QR Customer'
            ]);
    }

    /**
     * ========================
     * HELPER METHODS
     * ========================
     */

    public function getCustomerName(): string
    {
        return $this->customer
            ? "{$this->customer->first_name} {$this->customer->last_name}"
            : __('walk_in');
    }

    /**
     * Total harga (qty × price)
     */
    public function total(): float
    {
        if ($this->relationLoaded('items')) {
            return (float) $this->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        }

        return (float) $this->items()
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;
    }

    public function formattedTotal(): string
    {
        return \number_format($this->total(), 0, ',', '.');
    }

    /**
     * ========================
     * PAYMENT LOGIC
     * ========================
     */

    public function receivedAmount(): float
    {
        if ($this->relationLoaded('payments')) {
            return (float) $this->payments->sum(fn($payment) => (float) $payment->amount);
        }

        return (float) $this->payments()->sum('amount');
    }

    public function formattedReceivedAmount(): string
    {
        return \number_format($this->receivedAmount(), 0, ',', '.');
    }

    public function remainingBalance(): float
    {
        return $this->total() - $this->receivedAmount();
    }

    public function isFullyPaid(): bool
    {
        return $this->receivedAmount() >= $this->total();
    }

    /**
     * ========================
     * STATUS SYSTEM (QR READY)
     * ========================
     */

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'paid' => 'Lunas',
            default => 'Unknown'
        };
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * ========================
     * SCOPES
     * ========================
     */

    public function scopeByCustomer(Builder $query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeDateRange(Builder $query, string $startDate, string $endDate)
    {
        return $query->whereBetween('created_at', [
            $startDate,
            $endDate . ' 23:59:59'
        ]);
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid(Builder $query)
    {
        return $query->where('status', 'paid');
    }
}
