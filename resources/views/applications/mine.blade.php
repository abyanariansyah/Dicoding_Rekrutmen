@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Lamaran Saya</h1>
    <p>Melihat status lamaran yang pernah diajukan.</p>

    <div id="loading" style="text-align: center; padding: 40px;">
        <p>Loading applications...</p>
    </div>

    <table class="table" id="apps-table" style="display: none;">
        <thead>
            <tr>
                <th>Lowongan</th>
                <th>Perusahaan</th>
                <th>Status</th>
                <th>Diajukan</th>
            </tr>
        </thead>
        <tbody id="apps-body">
        </tbody>
    </table>

    <p id="empty-message" style="display: none; color: #6b7280; text-align: center; padding: 40px;">
        Belum ada lamaran diajukan.
    </p>
</div>

<script>
async function loadMyApplications() {
    try {
        const result = await api.getApplications({ per_page: 100 });
        
        document.getElementById('loading').style.display = 'none';
        
        if (!result.success || !result.data.length) {
            document.getElementById('empty-message').style.display = 'block';
            return;
        }
        
        const tbody = document.getElementById('apps-body');
        
        result.data.forEach(app => {
            const createdDate = new Date(app.created_at).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
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
        
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loading').innerHTML = '<p style="color: red;">Gagal memuat lamaran</p>';
    }
}

document.addEventListener('DOMContentLoaded', loadMyApplications);
</script>
@endsection
