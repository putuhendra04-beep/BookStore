@extends('layouts.app')

@section('title', 'Dashboard Home')

@section('content')
<style>
    /* ===== Layout dan Footer Fix ===== */
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1 0 auto;
    }
    footer {
        flex-shrink: 0;
    }

    /* ===== Card Hover & Shadow ===== */
    .card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* ===== Warna Card Kustom ===== */
    .bg-primary-custom { background: linear-gradient(135deg, #007bff, #33b5e5); }
    .bg-warning-custom { background: linear-gradient(135deg, #fbc02d, #ff9800); }
    .bg-danger-custom  { background: linear-gradient(135deg, #ff5252, #d32f2f); }
    .bg-success-custom { background: linear-gradient(135deg, #4caf50, #2e7d32); }

    /* ===== Teks di Card ===== */
    .card h5 {
        font-weight: bold;
        font-size: 1.25rem;
    }

    /* ===== Tombol di Card ===== */
    .card a.btn-light {
        font-weight: 600;
        border-radius: 8px;
        transition: 0.3s;
    }
    .card a.btn-light:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }

    /* ===== Judul Halaman ===== */
    .page-title {
        font-weight: 700;
        color: #0d6efd;
        letter-spacing: 0.5px;
    }
</style>

<main class="flex-grow-1">
    <div class="container py-5">
        {{-- 🔹 Judul --}}
        <div class="text-center mb-5">
            <h1 class="page-title">📚 Dashboard Bookstore</h1>
            <p class="text-muted">Selamat datang di aplikasi pengelolaan buku — pantau semua data dengan mudah.</p>
        </div>

        {{-- 🔹 Card Statistik --}}
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card bg-warning-custom text-white text-center shadow-lg">
                    <div class="card-body py-4">
                        <h5>{{ $totalBuku }} Buku</h5>
                        <p class="small mb-3">Total Buku Terdaftar</p>
                        <a href="{{ route('books.index') }}" class="btn btn-light btn-sm">Selengkapnya »</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary-custom text-white text-center shadow-lg">
                    <div class="card-body py-4">
                        <h5>{{ $totalKategori }} Kategori</h5>
                        <p class="small mb-3">Total Kategori Buku</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">Selengkapnya »</a>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card bg-danger-custom text-white text-center shadow-lg">
                    <div class="card-body py-4">
                        <h5>{{ $totalRating }} Rating</h5>
                        <p class="small mb-3">Total Penilaian Pengguna</p>
                        <a href="{{ route('ratings.index') }}" class="btn btn-light btn-sm">Selengkapnya »</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success-custom text-white text-center shadow-lg">
                    <div class="card-body py-4">
                        <h5>{{ $totalPenulis }} Penulis</h5>
                        <p class="small mb-3">Jumlah Penulis Terdaftar</p>
                        <a href="{{ route('authors.index') }}" class="btn btn-light btn-sm">Selengkapnya »</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔹 Bagian Bawah (opsional, misalnya grafik atau ringkasan) --}}
        <div class="mt-5 text-center text-muted"></div>
    </div>
</main>
@endsection
