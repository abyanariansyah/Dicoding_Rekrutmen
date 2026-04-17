@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h1>Login</h1>
    <p>Masuk sebagai Admin atau Pelamar untuk lanjut ke aplikasi rekrutmen.</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
            @foreach($errors->all() as $error)
                <p style="margin: 5px 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="input" placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="input" required>
        </div>
        <div class="field">
            <label><input type="checkbox" name="remember"> Ingat saya</label>
        </div>
        <button type="submit" class="button" style="width:100%;">Masuk</button>
    </form>

    <p style="margin-top:20px; text-align:center;">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </p>
</div>
@endsection
