<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama customer
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi milik customer
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->get();

        // Statistik sederhana
        $totalTransaksi = $orders->count();
        $totalBelanja = $orders->sum('total');

        return view('customer.dashboard', [
            'user' => $user,
            'orders' => $orders,
            'totalTransaksi' => $totalTransaksi,
            'totalBelanja' => $totalBelanja
        ]);
    }

    /**
     * Detail transaksi
     */
    public function show(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('customer.detail', compact('order'));
    }
}
