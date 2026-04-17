@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h1>Register</h1>
    <p>Buat akun pelamar untuk mengajukan lamaran pekerjaan.</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
            @foreach($errors->all() as $error)
                <p style="margin: 5px 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="field">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="input" placeholder="Nama Anda" value="{{ old('name') }}" required>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="input" placeholder="contoh@email.com" value="{{ old('email') }}" required>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="input" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="input" required>
        </div>

        <button type="submit" class="button" style="width:100%;">Daftar</button>
    </form>

    <p style="margin-top:20px; text-align:center;">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </p>
</div>
@endsection
