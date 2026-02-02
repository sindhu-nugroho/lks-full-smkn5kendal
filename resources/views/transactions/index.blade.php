@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Riwayat Peminjaman</h3>
        @if(Auth::user()->role !== 'user')
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Input Pinjaman Baru
            </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Peminjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Buku yang Dipinjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Tgl Pinjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Jatuh Tempo</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaksi)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $transaksi->user->name }}</div>
                                <small class="text-muted">{{ $transaksi->user->email }}</small>
                            </td>
                            <td>
                                @foreach($transaksi->details as $buku)
                                    <span class="badge bg-info text-dark rounded-pill me-1 fw-normal">
                                        <i class="fas fa-book me-1 small"></i> {{ $buku->judul }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="text-center text-muted">
                                {{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d M Y') }}
                            </td>
                            <td class="text-center text-muted">
                                {{ \Carbon\Carbon::parse($transaksi->tgl_jatuh_tempo)->format('d M Y') }}
                            </td>
                            <td class="text-center">
                                @if($transaksi->status == 'pinjam')
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Kembali
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada data transaksi peminjaman.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection