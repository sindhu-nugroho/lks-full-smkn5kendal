@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Riwayat Transaksi Anggota</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Buku yang Dipinjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $index => $transaksi)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            @foreach($transaksi->details as $buku)
                                <div class="fw-bold text-primary">{{ $buku->judul }}</div>
                                <small class="text-muted">ISBN: {{ $buku->isbn }}</small><br>
                            @endforeach
                        </td>
                        <td>{{ $transaksi->tgl_pinjam }}</td>
                        <td>{{ $transaksi->tgl_jatuh_tempo }}</td>
                        <td class="text-center">
                            <span class="badge {{ $transaksi->status == 'pinjam' ? 'bg-warning' : 'bg-success' }}">
                                {{ strtoupper($transaksi->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection