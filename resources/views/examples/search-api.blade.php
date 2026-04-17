<!-- Example 2: Search & Filter Jobs dengan API -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Cari Job</h2>
            
            <div class="card p-4">
                <form id="search-form">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="search" 
                                   placeholder="Cari job atau company..." />
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="job_type">
                                <option value="">Semua Tipe</option>
                                <option value="fulltime">Full Time</option>
                                <option value="parttime">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="location" 
                                   placeholder="Lokasi..." />
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary w-100" 
                                    onclick="searchJobs()">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="results-loading" style="display: none;" class="text-center">
        <p>Loading...</p>
    </div>
    
    <div id="results-container" class="row"></div>
</div>

<script>
async function searchJobs() {
    const search = document.getElementById('search').value;
    const jobType = document.getElementById('job_type').value;
    const location = document.getElementById('location').value;
    
    document.getElementById('results-loading').style.display = 'block';
    
    try {
        // Build query params
        let url = '/api/v1/jobs?per_page=20';
        if (search) url += `&search=${encodeURIComponent(search)}`;
        if (jobType) url += `&job_type=${jobType}`;
        if (location) url += `&location=${encodeURIComponent(location)}`;
        
        const response = await fetch(url);
        const data = await response.json();
        
        document.getElementById('results-loading').style.display = 'none';
        const container = document.getElementById('results-container');
        container.innerHTML = '';
        
        if (data.data.length === 0) {
            container.innerHTML = '<div class="col-12"><p class="text-center">Tidak ada job ditemukan</p></div>';
            return;
        }
        
        data.data.forEach(job => {
            const jobCard = `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${job.title}</h5>
                            <p class="card-text">
                                <strong>${job.company.name}</strong><br>
                                ${job.description.substring(0, 150)}...
                            </p>
                            <button class="btn btn-sm btn-info" 
                                    onclick="viewDetails(${job.id})">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += jobCard;
        });
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('results-loading').innerHTML = 
            '<p class="text-danger">Gagal search jobs</p>';
    }
}

function viewDetails(jobId) {
    window.location.href = `/jobs/${jobId}/apply`;
}

// Auto-load on page load
document.addEventListener('DOMContentLoaded', searchJobs);
</script>
@endsection
