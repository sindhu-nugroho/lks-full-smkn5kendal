@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Pengaturan Pengguna</h3>
            <p class="text-muted small mb-0">Kelola hak akses dan data akun perpustakaan.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Tambah User Baru
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
                            <th class="py-3 text-uppercase small fw-bold text-muted">Nama Lengkap</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Email</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Role / Hak Akses</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">Dibuat: {{ $user->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td><span class="text-muted">{{ $user->email }}</span></td>
                            <td class="text-center">
                                @if($user->role == 'superadmin')
                                    <span class="badge bg-dark rounded-pill px-3">Superadmin</span>
                                @elseif($user->role == 'admin')
                                    <span class="badge bg-primary rounded-pill px-3">Admin</span>
                                @else
                                    <span class="badge bg-light text-dark border rounded-pill px-3">Anggota</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->id !== Auth::id()) {{-- Mencegah menghapus akun sendiri --}}
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-dark fw-bold px-3" title="Edit Role">
                                        Edit
                                    </button>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold px-3" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="badge bg-secondary opacity-50">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role / Hak Akses</label>
                        <select name="role" class="form-select" required>
                            <option value="user" selected>Anggota (Hanya Lihat)</option>
                            <option value="admin">Admin (Input Peminjaman)</option>
                            <option value="superadmin">Superadmin (Kelola User/Buku)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection