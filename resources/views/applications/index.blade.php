@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Semua Lamaran</h1>
    <p>Kelola status lamaran yang masuk dari pelamar.</p>

    <div id="loading" style="text-align: center; padding: 40px;">
        <p>Loading applications...</p>
    </div>

    <table class="table" id="apps-table" style="display: none;">
        <thead>
            <tr>
                <th>Pelamar</th>
                <th>Lowongan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="apps-body">
        </tbody>
    </table>

    <p id="empty-message" style="display: none; color: #6b7280; text-align: center; padding: 40px;">
        Belum ada lamaran.
    </p>
</div>

<script>
async function loadApplications() {
    try {
        const result = await api.getApplications({ per_page: 100 });
        
        document.getElementById('loading').style.display = 'none';
        
        if (!result.success || !result.data.length) {
            document.getElementById('empty-message').style.display = 'block';
            return;
        }
        
        const tbody = document.getElementById('apps-body');
        
        result.data.forEach(app => {
            const statusColor = app.status === 'accepted' ? '#16a34a' 
                              : app.status === 'rejected' ? '#dc2626' 
                              : '#f59e0b';
            
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <strong>${app.user?.name || 'Unknown'}</strong><br>
                    <small style="color: #6b7280;">${app.user?.email || 'N/A'}</small>
                </td>
                <td>${app.job?.title || 'Unknown'}</td>
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
                <td>
                    <select id="status-${app.id}" class="select" style="font-size: 12px; padding: 4px 8px; width: auto;">
                        <option value="pending" ${app.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="accepted" ${app.status === 'accepted' ? 'selected' : ''}>Accepted</option>
                        <option value="rejected" ${app.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                    </select>
                    <button class="button button-small" style="margin-top: 5px;" onclick="updateStatus(${app.id})">
                        Update
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
        
        document.getElementById('apps-table').style.display = 'table';
        
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loading').innerHTML = '<p style="color: red;">Gagal memuat lamaran</p>';
    }
}

async function updateStatus(appId) {
    const status = document.getElementById(`status-${appId}`).value;
    
    try {
        const result = await api.put(`/applications/${appId}/status`, { status: status });
        
        if (result.success) {
            alert('Status updated!');
            loadApplications();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal update status');
    }
}

document.addEventListener('DOMContentLoaded', loadApplications);
</script>
@endsection
