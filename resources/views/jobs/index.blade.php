@extends('layouts.app')
@section('content')
<style>
.job-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 0;
    transition: box-shadow .15s;
}
.job-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,.07); }

.logo-box {
    width: 48px; height: 48px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: #6b7280;
    margin-bottom: 10px;
    overflow: hidden;
}
.logo-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 9px; }

.co-name { font-size: 13px; color: #2563eb; font-weight: 500; margin-bottom: 4px; }

.verified {
    display: flex; align-items: center; gap: 4px;
    font-size: 12px; color: #16a34a; margin-bottom: 6px;
}

.job-title { font-size: 16px; font-weight: 600; color: #111827; line-height: 1.4; margin-bottom: 14px; }

.tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
.tag {
    font-size: 12px; padding: 4px 12px;
    border-radius: 20px; border: 1px solid #d1d5db;
    color: #374151; background: #fff;
}
.tag-type    { border-color: #bfdbfe; color: #1d4ed8; background: #eff6ff; }
.tag-urgent  { border-color: #fecaca; color: #b91c1c; background: #fef2f2; }
.tag-premium { border-color: #fed7aa; color: #c2410c; background: #fff7ed; }

.divider { border: none; border-top: 1px solid #f3f4f6; margin-bottom: 14px; }

.location { display: flex; align-items: center; gap: 5px; font-size: 13px; color: #6b7280; margin-bottom: 5px; }

.salary-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px; }
.salary { font-size: 14px; font-weight: 600; color: #111827; }
.time   { font-size: 12px; color: #9ca3af; }

.btn-lamar {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 13px; font-weight: 500;
    color: #2563eb; background: #eff6ff;
    border-radius: 8px; padding: 7px 16px;
    text-decoration: none; width: fit-content;
    border: none; cursor: pointer;
}
.btn-lamar:hover { background: #dbeafe; }

.search-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px;
    margin-bottom: 20px;
}

.search-card input,
.search-card select {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
}

.grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px; }
</style>

<div class="max-w-6xl mx-auto p-6" style="background:#f3f4f6;min-height:100vh">
    <!-- Search & Filter -->
    <div class="search-card">
        <h3 style="margin-top: 0;">Cari Lowongan</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <div>
                <label style="display:block; font-size:12px; margin-bottom:4px;">Search</label>
                <input type="text" id="search" placeholder="Judul atau perusahaan..." />
            </div>
            <div>
                <label style="display:block; font-size:12px; margin-bottom:4px;">Tipe</label>
                <select id="job_type">
                    <option value="">Semua Tipe</option>
                    <option value="fulltime">Full Time</option>
                    <option value="parttime">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:12px; margin-bottom:4px;">Lokasi</label>
                <input type="text" id="location" placeholder="Lokasi..." />
            </div>
            <button class="button" onclick="searchJobs()" style="margin:0;">Search</button>
        </div>
    </div>

    <!-- Loading & Results -->
    <div id="loading" style="text-align:center; padding:40px;">
        <p>Loading jobs...</p>
    </div>
    
    <div id="results" class="grid" style="display:none;"></div>
</div>

<script>
async function loadJobs() {
    try {
        const result = await api.getJobs({ per_page: 50 });
        
        document.getElementById('loading').style.display = 'none';
        document.getElementById('results').style.display = 'grid';
        
        if (!result.success || !result.data.length) {
            document.getElementById('results').innerHTML = '<p>Tidak ada job ditemukan</p>';
            return;
        }
        
        renderJobs(result.data);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loading').innerHTML = '<p style="color:red;">Gagal memuat jobs</p>';
    }
}

async function searchJobs() {
    const search = document.getElementById('search').value;
    const jobType = document.getElementById('job_type').value;
    const location = document.getElementById('location').value;
    
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';
    
    try {
        const result = await api.getJobs({
            search: search || undefined,
            job_type: jobType || undefined,
            location: location || undefined,
            per_page: 50
        });
        
        document.getElementById('loading').style.display = 'none';
        document.getElementById('results').style.display = 'grid';
        
        if (!result.data.length) {
            document.getElementById('results').innerHTML = '<p>Tidak ada job ditemukan</p>';
            return;
        }
        
        renderJobs(result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderJobs(jobs) {
    let html = '';
    jobs.forEach(job => {
        const companyName = job.company?.name || 'Unknown';
        const companyInitial = companyName.substring(0, 2).toUpperCase();
        const salary = job.salary_min && job.salary_max 
            ? `Rp ${job.salary_min.toLocaleString('id-ID')} – Rp ${job.salary_max.toLocaleString('id-ID')}` 
            : 'Negotiable';
        const createdDate = new Date(job.created_at).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
        
        html += `
            <div class="job-card">
                <div class="logo-box">${companyInitial}</div>
                <div class="co-name">${companyName}</div>
                <div class="verified">
                    <svg width="13" height="13" viewBox="0 0 13 13">
                        <circle cx="6.5" cy="6.5" r="6.5" fill="#16a34a"/>
                        <path d="M3.8 6.5l2 2 3.4-3.8" stroke="#fff" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                    Verified
                </div>
                
                <div class="job-title">${job.title}</div>
                
                <div class="tags">
                    <span class="tag tag-type">${job.job_type}</span>
                    <span class="tag">${job.experience_level}</span>
                    ${job.category ? `<span class="tag">${job.category.name}</span>` : ''}
                </div>
                
                <hr class="divider">
                
                <div class="location">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M6 1a3.5 3.5 0 013.5 3.5C9.5 7.5 6 11 6 11S2.5 7.5 2.5 4.5A3.5 3.5 0 016 1z" fill="#9ca3af"/>
                        <circle cx="6" cy="4.5" r="1.2" fill="#fff"/>
                    </svg>
                    ${job.location}
                </div>
                
                <div class="salary-row">
                    <span class="salary">${salary}</span>
                    <span class="time">${createdDate}</span>
                </div>
                
                <button class="btn-lamar" onclick="applyJob(${job.id}, '${job.title.replace(/'/g, "\\'")}')">
                    Lamar →
                </button>
            </div>
        `;
    });
    
    document.getElementById('results').innerHTML = html;
}

function applyJob(jobId, jobTitle) {
    const token = localStorage.getItem('api_token');
    
    if (!token) {
        alert('Silahkan login terlebih dahulu');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    window.location.href = `/jobs/${jobId}/apply`;
}

// Load jobs on page load
document.addEventListener('DOMContentLoaded', loadJobs);
</script>
@endsection