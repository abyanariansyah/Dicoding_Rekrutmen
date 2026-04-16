@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Login</h1>
    <p>Masuk sebagai Admin atau Pelamar untuk lanjut ke aplikasi rekrutmen.</p>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="input" required autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="input" required>
        </div>
        <div class="field">
            <label><input type="checkbox" name="remember"> Ingat saya</label>
        </div>
        <button type="submit" class="button">Masuk</button>
    </form>
</div>
@endsection
