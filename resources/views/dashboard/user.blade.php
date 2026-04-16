@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Dashboard Pelamar</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Lihat lowongan terbaru dan status lamaranmu.</p>

    <div class="card" style="background:#eff6ff; border-color:#dbeafe;">
        <h2>Lowongan Terbaru</h2>
        @if($jobs->isEmpty())
            <p>Tidak ada lowongan saat ini.</p>
        @else
            <ul style="padding-left: 18px; margin: 0;">
                @foreach($jobs as $job)
                    <li style="margin-bottom: 10px;">
                        <strong>{{ $job->title }}</strong> - deadline {{ $job->deadline->format('d M Y') }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="card" style="background:#f8fafc; border-color:#e5e7eb;">
        <h2>Status Lamaran Saya</h2>
        @if($applications->isEmpty())
            <p>Belum ada lamaran diajukan.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->job->title }}</td>
                            <td>{{ $application->status }}</td>
                            <td>{{ $application->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
