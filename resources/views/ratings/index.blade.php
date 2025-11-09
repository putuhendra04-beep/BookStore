@extends('layouts.app')

@section('title', '⭐ Data Rating Buku')

@section('content')
    <div class="container mt-4">
        <h2 class="fw-bold text-primary mb-4 text-center">⭐ Daftar Rating Buku</h2>

        {{-- 🔍 Search Form --}}
        {{-- 🔍 Form Pencarian --}}
        <form method="GET" action="{{ route('ratings.index') }}" class="d-flex justify-content-center mb-4">
            <div class="input-group" style="max-width: 600px;">
                <span class="input-group-text bg-primary text-white">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Cari buku atau komentar..."
                    value="{{ request('search') }}">

                <button class="btn btn-outline-primary" type="submit">Cari</button>

                {{-- 🔁 Tombol Reset --}}
                @if(request('search'))
                    <a href="{{ route('ratings.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>



        {{-- 📋 Tabel Data Rating --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Nama User / IP</th>
                                <th>Nilai Rating</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ratings as $index => $rating)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($ratings->currentPage() - 1) * $ratings->perPage() }}
                                    </td>
                                    <td class="fw-semibold">{{ $rating->book->judul ?? '-' }}</td>
                                    <td>
                                        @if($rating->user)
                                            👤 {{ $rating->user->name }}
                                        @else
                                            🌐 {{ $rating->guest_ip ?? 'Guest' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark fs-6">{{ $rating->score }}/10</span>
                                    </td>
                                    <td>{{ $rating->comment ?? '-' }}</td>
                                    <td class="text-center">{{ $rating->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data rating.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 🔹 Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $ratings->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- 🔻 Footer agar selalu di bawah --}}
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
        }
    </style>
@endsection