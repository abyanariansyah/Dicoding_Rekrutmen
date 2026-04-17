@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Rekrutmen Online Perusahaan</h1>
    <p>Selamat datang di sistem rekrutmen. Admin dapat mengelola lowongan dan status lamaran, sedangkan pelamar dapat mendaftar dan melihat hasil lamarannya.</p>

    <div style="display:grid; gap:18px; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); margin-top:24px;">
        @auth
        @else
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
        @endauth
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

    <!-- Recent Jobs from API -->
    <div style="margin-top: 40px;">
        <h2>Lowongan Terbaru</h2>
        <div id="jobs-loading" style="text-align: center; padding: 40px;">
            <p>Loading jobs...</p>
        </div>
        <div id="jobs-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:15px; margin-top:20px;"></div>
    </div>
</div>

<script>
async function loadRecentJobs() {
    try {
        const result = await api.getJobs({ per_page: 6 });
        
        document.getElementById('jobs-loading').style.display = 'none';
        
        if (!result.success || !result.data.length) {
            document.getElementById('jobs-loading').innerHTML = '<p>Belum ada lowongan.</p>';
            return;
        }
        
        let html = '';
        result.data.forEach(job => {
            const salary = job.salary_min && job.salary_max
                ? `Rp ${job.salary_min.toLocaleString('id-ID')} - Rp ${job.salary_max.toLocaleString('id-ID')}`
                : 'Negotiable';
            
            html += `
                <div class="card" style="cursor: pointer;" onclick="window.location.href='/jobs'">
                    <h4 style="margin-top:0;">${job.title}</h4>
                    <p style="margin: 5px 0; color: #2563eb; font-weight: 500;">
                        ${job.company?.name || 'Unknown Company'}
                    </p>
                    <p style="margin: 5px 0; color: #6b7280; font-size: 14px;">
                        📍 ${job.location}
                    </p>
                    <p style="margin: 5px 0; color: #6b7280; font-size: 14px;">
                        💼 ${job.job_type}
                    </p>
                    <p style="margin: 5px 0; font-weight: 500; color: #111827;">
                        ${salary}
                    </p>
                    <button style="
                        margin-top: 10px;
                        padding: 8px 16px;
                        background: #2563eb;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        font-weight: 500;
                    " onclick="window.location.href='{{ route("jobs.index") }}'">
                        Lihat Lowongan →
                    </button>
                </div>
            `;
        });
        
        document.getElementById('jobs-grid').innerHTML = html;
        
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('jobs-loading').innerHTML = '<p style="color: red;">Gagal memuat lowongan</p>';
    }
}

document.addEventListener('DOMContentLoaded', loadRecentJobs);
</script>
@endsection
