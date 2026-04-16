<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Rekrutmen') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">🚀 Rekrutmen</a>
            <div class="flex gap-4 flex-wrap justify-end">
                @auth
                    <div class="flex gap-3 items-center flex-wrap">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kelola Lowongan</a>
                            <a href="{{ route('admin.applications.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Lamaran Masuk</a>
                        @else
                            <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cari Pekerjaan</a>
                            <a href="{{ route('applications.mine') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Lamaran Saya</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 border-2 border-blue-600 text-blue-600 rounded hover:bg-blue-50">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 max-w-6xl mx-auto mt-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 max-w-6xl mx-auto mt-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 max-w-6xl mx-auto mt-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Rekrutmen Online</h3>
                    <p class="text-gray-400">Platform rekrutmen terpadu untuk mencari talenta terbaik Indonesia.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('jobs.index') }}" class="hover:text-white">Cari Pekerjaan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <p class="text-gray-400">Email: info@rekrutmen.com</p>
                    <p class="text-gray-400">Phone: (021) 1234-5678</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2026 Rekrutmen Online. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
