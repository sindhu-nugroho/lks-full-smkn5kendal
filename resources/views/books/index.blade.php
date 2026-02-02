@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Master Data Buku</h3>
            <p class="text-muted small mb-0">Kelola koleksi buku perpustakaan Anda di sini.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addBookModal">
            <i class="fas fa-plus-circle me-2"></i> Tambah Buku Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 50px;">No</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Buku</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">ISBN</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Stok</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $index => $buku)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $buku->judul }}</div>
                                <small class="text-muted">ID: #B{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td><code class="text-primary">{{ $buku->isbn }}</code></td>
                            <td class="text-center">
                                @if($buku->stok <= 2)
                                    <span class="badge bg-danger rounded-pill px-3">{{ $buku->stok }}</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3">{{ $buku->stok }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-book-open fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada koleksi buku.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBookModalLabel">Tambah Koleksi Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Contoh: 978-602-..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" min="1" value="1" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection