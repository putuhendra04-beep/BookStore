@extends('layouts.app')

@section('title', '⭐ Beri Rating Buku')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- 🔹 Card Utama --}}
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0 text-center">⭐ Beri Rating untuk <span class="fw-bold">"{{ $book->judul }}"</span></h4>
                </div>

                <div class="card-body p-4 bg-light">
                    <form method="POST" action="{{ route('ratings.store') }}">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">

                        {{-- Nilai Rating --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Nilai (1–10)</label>
                            <select name="score" class="form-select form-select-lg shadow-sm @error('score') is-invalid @enderror" required>
                                <option value="">⭐ Pilih Rating</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" @selected(old('score') == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Komentar (Opsional)</label>
                            <textarea 
                                name="comment" 
                                class="form-control shadow-sm @error('comment') is-invalid @enderror" 
                                rows="4" 
                                placeholder="Tulis pendapatmu tentang buku ini...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-start gap-3 mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-4 py-2 rounded-3 shadow-sm">
                                Kirim 
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center bg-white border-top-0 text-muted small">
                    Terima kasih sudah ikut menilai buku ini 
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🔹 CSS tambahan untuk efek halus --}}
<style>
    select.form-select:hover,
    textarea.form-control:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        transition: all 0.2s ease-in-out;
    }

    .btn-success:hover {
        background-color: #28a745cc !important;
        transform: scale(1.03);
        transition: all 0.2s;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.03);
        transition: all 0.2s;
    }
</style>
@endsection
