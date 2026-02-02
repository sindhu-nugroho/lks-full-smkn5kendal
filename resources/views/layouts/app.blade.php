<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Mandiri</title>
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --accent-color: #34495e;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Design */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background-color: rgba(0,0,0,0.1);
            font-weight: bold;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: var(--accent-color);
            border-left: 4px solid #3498db;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-area {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            PERPUSTAKAAN
        </div>
        <div class="py-3">
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->is('transaksi') ? 'active' : '' }}">
                <i class="fas fa-history me-2"></i> Riwayat Pinjam
            </a>

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
            <a href="{{ route('transaksi.create') }}" class="nav-link {{ request()->is('transaksi/create') ? 'active' : '' }}">
                <i class="fas fa-plus me-2"></i> Input Pinjaman
            </a>
            @endif

            @if(Auth::user()->role == 'superadmin')
            <div class="px-3 py-2 small text-uppercase text-muted opacity-50">Master Data</div>
            <a href="{{ route('buku.index') }}" class="nav-link {{ request()->is('buku*') ? 'active' : '' }}">
                <i class="fas fa-book me-2"></i> Data Buku
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Data User
            </a>
            @endif

            <div class="mt-4 px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <nav class="top-navbar">
            <div class="text-muted">Aplikasi Perpustakaan v1.0</div>
            <div class="fw-bold">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} 
                <span class="badge bg-primary ms-1" style="font-size: 0.7rem;">{{ strtoupper(Auth::user()->role) }}</span>
            </div>
        </nav>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>