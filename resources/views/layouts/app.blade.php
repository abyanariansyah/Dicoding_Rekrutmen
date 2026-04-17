<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Rekrutmen') }}</title>
    <style>
        body { margin: 0; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f7fafc; color: #1f2937; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px; }
        .card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 3px rgba(15,23,42,.08); padding: 24px; margin-bottom: 24px; }
        .button { display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; padding: 10px 18px; font-weight: 600; text-decoration: none; color: #ffffff; background: #2563eb; border: 1px solid transparent; }
        .button-muted { background: #6b7280; }
        .button-danger { background: #dc2626; }
        .button-small { padding: 8px 14px; font-size: .95rem; }
        .input, .textarea, .select { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; font-size: 1rem; margin-top: 8px; }
        .textarea { min-height: 140px; resize: vertical; }
        .field { margin-bottom: 18px; }
        .nav { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .nav-links { display: flex; flex-wrap: wrap; gap: 10px; }
        .badge { display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; color: #0369a1; border-radius: 9999px; padding: 6px 12px; font-size: .95rem; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { padding: 12px 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .table th { background: #f8fafc; font-weight: 700; }
        .alert { padding: 14px 18px; border-radius: 10px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        a { color: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <header class="nav">
            <div>
                <a href="{{ route('home') }}" class="button button-small">Beranda</a>
            </div>
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="button button-small">Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.jobs.index') }}" class="button button-small button-muted">Kelola Lowongan</a>
                        <a href="{{ route('admin.applications.index') }}" class="button button-small button-muted">Semua Lamaran</a>
                    @else
                        <a href="{{ route('jobs.index') }}" class="button button-small button-muted">Daftar Lowongan</a>
                        <a href="{{ route('applications.mine') }}" class="button button-small button-muted">Lamaran Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="button button-small button-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="button button-small">Login</a>
                    <a href="{{ route('register') }}" class="button button-small button-muted">Register</a>
                @endauth
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Vite - Loads app.js which includes API client -->
    @vite(['resources/js/app.js'])
</body>
</html>
