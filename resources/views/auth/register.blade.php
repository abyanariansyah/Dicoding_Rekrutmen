@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Register</h1>
    <p>Buat akun pelamar untuk mengajukan lamaran pekerjaan.</p>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="field">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" class="input" required>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="input" required>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="input" required>
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="input" required>
        </div>

        <button type="submit" class="button">Daftar</button>
    </form>
</div>
@endsection
