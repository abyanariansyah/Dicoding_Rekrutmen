<!-- Example 1: Consume API di Blade Template (JavaScript/AJAX) -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Jobs List (dari API)</h1>
    
    <div id="jobs-loading" class="text-center">
        <p>Loading jobs...</p>
    </div>
    
    <div id="jobs-container" class="row"></div>
</div>

<script>
// Fetch jobs dari API
async function loadJobs() {
    try {
        const response = await fetch('/api/v1/jobs?per_page=12');
        const data = await response.json();
        
        // Hide loading
        document.getElementById('jobs-loading').style.display = 'none';
        
        if (data.success) {
            const container = document.getElementById('jobs-container');
            
            data.data.forEach(job => {
                const jobCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">${job.title}</h5>
                                <p class="card-text">
                                    <strong>${job.company.name}</strong><br>
                                    📍 ${job.location}<br>
                                    💼 ${job.job_type}
                                </p>
                                <p class="text-muted small">${job.description.substring(0, 100)}...</p>
                                
                                <div class="mb-3">
                                    <span class="badge bg-primary">${job.salary_min.toLocaleString('id-ID')}</span>
                                    -
                                    <span class="badge bg-primary">${job.salary_max.toLocaleString('id-ID')}</span>
                                </div>
                                
                                <a href="/jobs/${job.id}/apply" class="btn btn-primary btn-sm w-100">
                                    Lihat & Apply
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += jobCard;
            });
        }
    } catch (error) {
        console.error('Error loading jobs:', error);
        document.getElementById('jobs-loading').innerHTML = 
            '<p class="text-danger">Gagal memuat jobs</p>';
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', loadJobs);
</script>
@endsection
