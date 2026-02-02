<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Mandiri</title>
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            background: white;
            overflow: hidden;
        }

        .login-header {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .login-header h3 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .login-body {
            padding: 40px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            border-color: #3498db;
        }

        .btn-login {
            background-color: #2c3e50;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
        }

        .error-message {
            font-size: 0.85rem;
            color: #e74c3c;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h3>PERPUSTAKAAN</h3>
            <p class="text-muted small mb-0">Silakan masuk ke akun Anda</p>
        </div>
        
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    Email atau Password salah!
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-muted text-uppercase">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold text-muted text-uppercase">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> MASUK
                    </button>
                </div>
            </form>
        </div>
        
        <div class="text-center pb-4">
            <small class="text-muted">v1.0 &copy; 2026 Perpustakaan App</small>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>