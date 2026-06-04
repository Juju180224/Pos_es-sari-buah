<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan error default yang digunakan oleh
    | class validator. Beberapa aturan memiliki beberapa versi seperti
    | aturan ukuran. Anda bebas menyesuaikan setiap pesan di sini.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa array.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus antara :min dan :max.',
        'file' => 'Kolom :attribute harus antara :min dan :max kilobyte.',
        'string' => 'Kolom :attribute harus antara :min dan :max karakter.',
        'array' => 'Kolom :attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Kolom :attribute tidak sesuai dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',
    'digits_between' => 'Kolom :attribute harus terdiri dari antara :min dan :max digit.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai duplikat.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'file' => 'Kolom :attribute harus lebih besar dari :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih besar dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Kolom :attribute harus lebih besar atau sama dengan :value.',
        'file' => 'Kolom :attribute harus lebih besar atau sama dengan :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih besar atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute harus memiliki :value item atau lebih.',
    ],
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => 'Kolom :attribute tidak ada di :other.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'lt' => [
        'numeric' => 'Kolom :attribute harus lebih kecil dari :value.',
        'file' => 'Kolom :attribute harus lebih kecil dari :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih kecil dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Kolom :attribute harus lebih kecil atau sama dengan :value.',
        'file' => 'Kolom :attribute harus lebih kecil atau sama dengan :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih kecil atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Kolom :attribute tidak boleh lebih besar dari :max kilobyte.',
        'string' => 'Kolom :attribute tidak boleh lebih besar dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa file bertipe: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute minimal harus :min.',
        'file' => 'Kolom :attribute minimal harus :min kilobyte.',
        'string' => 'Kolom :attribute minimal harus :min karakter.',
        'array' => 'Kolom :attribute minimal harus memiliki :min item.',
    ],
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format kolom :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => 'Password salah.',
    'present' => 'Kolom :attribute harus ada.',
    'regex' => 'Format kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute wajib diisi saat :other adalah :value.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other berada di :values.',
    'required_with' => 'Kolom :attribute wajib diisi saat :values tersedia.',
    'required_with_all' => 'Kolom :attribute wajib diisi saat :values tersedia.',
    'required_without' => 'Kolom :attribute wajib diisi saat :values tidak tersedia.',
    'required_without_all' => 'Kolom :attribute wajib diisi saat tidak ada :values yang tersedia.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file' => 'Kolom :attribute harus berukuran :size kilobyte.',
        'string' => 'Kolom :attribute harus terdiri dari :size karakter.',
        'array' => 'Kolom :attribute harus berisi :size item.',
    ],
    'starts_with' => 'Kolom :attribute harus dimulai dengan salah satu dari berikut: :values.',
    'string' => 'Kolom :attribute harus berupa teks.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => 'Upload kolom :attribute gagal.',
    'url' => 'Format kolom :attribute tidak valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'nama-atribut' => [
            'nama-aturan' => 'pesan-kustom',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    */

    'attributes' => [],

];