@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Master Data Buku</h3>
            <p class="text-muted small mb-0">Kelola koleksi buku perpustakaan Anda di sini secara mandiri.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addBookModal">
            Tambah Buku Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">ID: #BKN-{{ $buku->id }}</small>
                            </td>
                            <td><code class="text-primary fw-bold">{{ $buku->isbn }}</code></td>
                            <td class="text-center">
                                @if($buku->stok <= 2)
                                    <span class="badge bg-danger rounded-pill px-3">Sisa {{ $buku->stok }}</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3">{{ $buku->stok }} Unit</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-warning text-dark fw-bold px-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editBookModal{{ $buku->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editBookModal{{ $buku->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title fw-bold text-dark">Edit Data Buku</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4 text-start">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Judul Buku</label>
                                                <input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Nomor ISBN</label>
                                                <input type="text" name="isbn" class="form-control" value="{{ $buku->isbn }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Jumlah Stok</label>
                                                <input type="number" name="stok" class="form-control" value="{{ $buku->stok }}" min="0" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-0">
                                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning px-4 fw-bold text-dark shadow-sm">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <h6 class="fw-bold text-muted">Belum ada koleksi buku.</h6>
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
                <h5 class="modal-title fw-bold" id="addBookModalLabel">Tambah Koleksi Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Belajar Laravel 11" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="978-xxx-xxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" min="1" value="1" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection