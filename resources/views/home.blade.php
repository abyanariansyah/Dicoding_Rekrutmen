@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Rekrutmen Online Perusahaan</h1>
    <p>Selamat datang di sistem rekrutmen. Admin dapat mengelola lowongan dan status lamaran, sedangkan pelamar dapat mendaftar dan melihat hasil lamarannya.</p>

    <div style="display:grid; gap:18px; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); margin-top:24px;">
        <div class="card" style="background:#eff6ff; border-color:#dbeafe;">
            <h3>Login</h3>
            <p>Masuk ke sistem sebagai Admin atau Pelamar.</p>
            <a href="{{ route('login') }}" class="button">Login</a>
        </div>
        <div class="card" style="background:#ecfccb; border-color:#d9f99d;">
            <h3>Register Pelamar</h3>
            <p>Buat akun pelamar untuk melamar pekerjaan.</p>
            <a href="{{ route('register') }}" class="button">Register</a>
        </div>
        <div class="card" style="background:#fef3c7; border-color:#fde68a;">
            <h3>Alur Sistem</h3>
            <ul style="margin:0; padding-left:18px;">
                <li>Login Admin / Pelamar</li>
                <li>Admin mengelola lowongan</li>
                <li>Pelamar mengajukan lamaran</li>
                <li>Admin memperbarui status</li>
            </ul>
        </div>
    </div>
</div>
@endsection
