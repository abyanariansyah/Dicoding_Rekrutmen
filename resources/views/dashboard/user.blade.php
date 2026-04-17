@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Dashboard Pelamar</h1>
    <p>Selamat datang, <span id="username">{{ auth()->user()->name }}</span>. Lihat lowongan terbaru dan status lamaranmu.</p>

    <!-- Recent Jobs -->
    <div class="card" style="background:#eff6ff; border-color:#dbeafe; margin-top: 20px;">
        <h2>Lowongan Terbaru</h2>
        <div id="jobs-loading">Loading...</div>
        <ul id="jobs-list" style="padding-left: 18px; margin: 0; display:none;">
        </ul>
    </div>

    <!-- My Applications -->
    <div class="card" style="background:#f8fafc; border-color:#e5e7eb; margin-top: 20px;">
        <h2>Status Lamaran Saya</h2>
        <div id="apps-loading">Loading...</div>
        <table class="table" id="apps-table" style="display:none;">
            <thead>
                <tr>
                    <th>Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Tanggal Apply</th>
                </tr>
            </thead>
            <tbody id="apps-body">
            </tbody>
        </table>
        <p id="apps-empty" style="display:none; color: #6b7280;">Belum ada lamaran diajukan.</p>
    </div>
</div>

<script>
async function loadRecentJobs() {
    try {
        const result = await api.getJobs({ per_page: 5 });
        
        document.getElementById('jobs-loading').style.display = 'none';
        
        if (result.success && result.data.length) {
            const jobsList = document.getElementById('jobs-list');
            jobsList.style.display = 'block';
            
            result.data.forEach(job => {
                const deadlineDate = new Date(job.deadline).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                
                const li = document.createElement('li');
                li.style.marginBottom = '10px';
                li.innerHTML = `
                    <strong>${job.title}</strong> 
                    (${job.company?.name || 'Unknown'}) 
                    - Deadline <strong>${deadlineDate}</strong>
                `;
                jobsList.appendChild(li);
            });
        } else {
            document.getElementById('jobs-loading').innerHTML = '<p>Tidak ada lowongan saat ini.</p>';
        }
    } catch (error) {
        console.error('Error loading jobs:', error);
        document.getElementById('jobs-loading').innerHTML = '<p style="color:red;">Gagal memuat jobs</p>';
    }
}

async function loadMyApplications() {
    try {
        const result = await api.getApplications({ per_page: 50 });
        
        document.getElementById('apps-loading').style.display = 'none';
        
        if (result.success && result.data.length) {
            const tbody = document.getElementById('apps-body');
            
            result.data.forEach(app => {
                const createdDate = new Date(app.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                const statusColor = app.status === 'accepted' ? '#16a34a' 
                                  : app.status === 'rejected' ? '#dc2626' 
                                  : '#f59e0b';
                
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${app.job?.title || 'Unknown'}</strong></td>
                    <td>${app.job?.company?.name || 'Unknown'}</td>
                    <td>
                        <span style="
                            display: inline-block;
                            padding: 6px 12px;
                            border-radius: 6px;
                            background-color: ${statusColor};
                            color: white;
                            font-size: 12px;
                            font-weight: 500;
                            text-transform: uppercase;
                        ">
                            ${app.status}
                        </span>
                    </td>
                    <td>${createdDate}</td>
                `;
                tbody.appendChild(tr);
            });
            
            document.getElementById('apps-table').style.display = 'table';
        } else {
            document.getElementById('apps-empty').style.display = 'block';
        }
    } catch (error) {
        console.error('Error loading applications:', error);
        document.getElementById('apps-loading').innerHTML = '<p style="color:red;">Gagal memuat aplikasi</p>';
    }
}

// Load data on page load
document.addEventListener('DOMContentLoaded', () => {
    loadRecentJobs();
    loadMyApplications();
});
</script>
@endsection
