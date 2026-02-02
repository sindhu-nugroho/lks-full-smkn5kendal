@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Input Peminjaman Baru</h3>
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="user_id" class="form-label fw-bold text-muted small text-uppercase">Peminjam / Anggota</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Pilih Anggota --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="book_ids" class="form-label fw-bold text-muted small text-uppercase">Buku yang Dipinjam</label>
                            <select name="book_ids[]" id="book_ids" class="form-select @error('book_ids') is-invalid @enderror" multiple required style="height: 150px;">
                                @foreach($books as $buku)
                                    <option value="{{ $buku->id }}" {{ (is_array(old('book_ids')) && in_array($buku->id, old('book_ids'))) ? 'selected' : '' }}>
                                        {{ $buku->judul }} - (Stok: {{ $buku->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i> Tahan tombol <strong>Ctrl</strong> (Windows) atau <strong>Command</strong> (Mac) untuk memilih lebih dari satu buku.
                            </div>
                            @error('book_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="tgl_pinjam" class="form-label fw-bold text-muted small text-uppercase">Tanggal Pinjam</label>
                                <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control @error('tgl_pinjam') is-invalid @enderror" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" required>
                                @error('tgl_pinjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="tgl_jatuh_tempo" class="form-label fw-bold text-muted small text-uppercase">Jatuh Tempo</label>
                                <input type="date" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-control @error('tgl_jatuh_tempo') is-invalid @enderror" value="{{ old('tgl_jatuh_tempo', date('Y-m-d', strtotime('+7 days'))) }}" required>
                                @error('tgl_jatuh_tempo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm py-3">
                                <i class="fas fa-save me-2"></i> Simpan Transaksi Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection