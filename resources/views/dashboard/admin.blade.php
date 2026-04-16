@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Dashboard Admin</h1>
    <p>Kelola lowongan dan lihat semua lamaran yang masuk.</p>

    <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); margin-top:20px;">
        <div class="card" style="background:#eff6ff; border-color:#dbeafe;">
            <strong>{{ $jobsCount }}</strong>
            <div>Lowongan</div>
        </div>
        <div class="card" style="background:#ecfdf5; border-color:#d1fae5;">
            <strong>{{ $applicationsCount }}</strong>
            <div>Total lamaran</div>
        </div>
        <div class="card" style="background:#fef3c7; border-color:#fde68a;">
            <strong>{{ $pendingCount }}</strong>
            <div>Pending</div>
        </div>
        <div class="card" style="background:#d1fae5; border-color:#a7f3d0;">
            <strong>{{ $acceptedCount }}</strong>
            <div>Diterima</div>
        </div>
        <div class="card" style="background:#fee2e2; border-color:#fecaca;">
            <strong>{{ $rejectedCount }}</strong>
            <div>Ditolak</div>
        </div>
    </div>
</div>
@endsection
