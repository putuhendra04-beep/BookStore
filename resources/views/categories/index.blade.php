@extends('layouts.app')

@section('title', '📖 Daftar Kategori')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold text-center text-primary">📖 Daftar Kategori</h2>

        {{-- 🔹 Card Wrapper --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $c)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $c->nama }}</td>
                                    <td class="text-center">{{ $c->books_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Tidak ada data kategori ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center gap-3">
                    {{ $categories->appends(request()->except('page'))->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
