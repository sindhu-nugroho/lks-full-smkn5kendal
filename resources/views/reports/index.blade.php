@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Perpustakaan</h3>
            <p class="text-muted small mb-0">Kelola dan cetak ringkasan data transaksi peminjaman.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-dark shadow-sm">
                <i class="fas fa-print me-2"></i> Cetak Halaman Ini
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" id="reportArea">
        <div class="card-header bg-white border-0 py-3 text-center border-bottom">
            <h4 class="fw-bold mb-0">REKAPITULASI PEMINJAMAN BUKU</h4>
            <small class="text-muted">Periode: {{ request('start_date') ?? 'Semua' }} s/d {{ request('end_date') ?? 'Semua' }}</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Peminjam</th>
                            <th>Daftar Buku</th>
                            <th class="text-center">Tgl Pinjam</th>
                            <th class="text-center">Tgl Kembali</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $t)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $t->user->name }}</div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($t->details as $buku)
                                        <li>- {{ $buku->judul }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center small">{{ $t->tgl_pinjam }}</td>
                            <td class="text-center small">{{ $t->tgl_kembali ?? '-' }}</td>
                            <td class="text-center">
                                @if($t->status == 'pinjam')
                                    <span class="text-danger fw-bold small text-uppercase">Masih Dipinjam</span>
                                @else
                                    <span class="text-success fw-bold small text-uppercase">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Data tidak ditemukan untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .btn, .card-header-filter, form {
        display: none !important;
    }
    .main-wrapper {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
    .table thead th {
        background-color: #000 !important;
        color: #fff !important;
    }
}
</style>
@endsection