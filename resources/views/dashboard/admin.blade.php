@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Dashboard Admin</h1>
    <p>Kelola lowongan dan lihat semua lamaran yang masuk.</p>

    <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); margin-top:20px;" id="stats-loading">
        <p>Loading statistics...</p>
    </div>

    <div id="stats-grid" style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); margin-top:20px; display:none;">
        <div class="card" style="background:#eff6ff; border-color:#dbeafe;">
            <strong id="jobs-count">0</strong>
            <div>Lowongan</div>
        </div>
        <div class="card" style="background:#ecfdf5; border-color:#d1fae5;">
            <strong id="apps-count">0</strong>
            <div>Total lamaran</div>
        </div>
        <div class="card" style="background:#fef3c7; border-color:#fde68a;">
            <strong id="pending-count">0</strong>
            <div>Pending</div>
        </div>
        <div class="card" style="background:#d1fae5; border-color:#a7f3d0;">
            <strong id="accepted-count">0</strong>
            <div>Diterima</div>
        </div>
        <div class="card" style="background:#fee2e2; border-color:#fecaca;">
            <strong id="rejected-count">0</strong>
            <div>Ditolak</div>
        </div>
    </div>
</div>

<script>
async function loadStatistics() {
    try {
        const jobsResult = await api.getJobs({ per_page: 1000 });
        const appsResult = await api.getApplications({ per_page: 1000 });
        
        const jobsCount = jobsResult.pagination?.total || 0;
        const appsCount = appsResult.pagination?.total || 0;
        
        let pendingCount = 0;
        let acceptedCount = 0;
        let rejectedCount = 0;
        
        if (appsResult.data) {
            appsResult.data.forEach(app => {
                if (app.status === 'pending') pendingCount++;
                else if (app.status === 'accepted') acceptedCount++;
                else if (app.status === 'rejected') rejectedCount++;
            });
        }
        
        document.getElementById('stats-loading').style.display = 'none';
        document.getElementById('stats-grid').style.display = 'grid';
        
        document.getElementById('jobs-count').textContent = jobsCount;
        document.getElementById('apps-count').textContent = appsCount;
        document.getElementById('pending-count').textContent = pendingCount;
        document.getElementById('accepted-count').textContent = acceptedCount;
        document.getElementById('rejected-count').textContent = rejectedCount;
        
    } catch (error) {
        console.error('Error loading statistics:', error);
        document.getElementById('stats-loading').innerHTML = '<p style="color: red;">Gagal memuat statistik</p>';
    }
}

document.addEventListener('DOMContentLoaded', loadStatistics);
</script>
@endsection
