@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div id="job-loading">
        <p>Loading job detail...</p>
    </div>
    
    <div id="job-detail" style="display:none;">
        <h1 id="job-title"></h1>
        <p id="job-company" style="color: #2563eb; font-weight: 500;"></p>
        
        <div style="background: #eff6ff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p id="job-location"></p>
            <p id="job-type"></p>
            <p id="job-deadline" style="color: red;"></p>
        </div>
        
        <div style="background: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 20px; max-height: 300px; overflow-y: auto;">
            <h3>Deskripsi Pekerjaan</h3>
            <div id="job-description"></div>
        </div>
        
        <div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <h3>Requirements</h3>
            <div id="job-requirements" style="white-space: pre-wrap;"></div>
        </div>
        
        <form id="apply-form">
            <div class="field">
                <label for="cover_letter">Cover Letter (Opsional)</label>
                <textarea id="cover_letter" class="textarea" placeholder="Tulis motivasi Anda bergabung dengan perusahaan ini..."></textarea>
            </div>
            <button type="submit" class="button" style="width: 100%;">Ajukan Lamaran</button>
        </form>
    </div>
</div>

<script>
const jobId = {{ $jobId ?? 'null' }};

async function loadJobDetail() {
    if (!jobId) {
        document.getElementById('job-loading').innerHTML = '<p style="color:red;">Job not found</p>';
        return;
    }
    
    try {
        const result = await api.getJob(jobId);
        
        if (!result.success) {
            document.getElementById('job-loading').innerHTML = '<p style="color:red;">Job tidak ditemukan</p>';
            return;
        }
        
        const job = result.data;
        
        // Populate job details
        document.getElementById('job-title').textContent = job.title;
        document.getElementById('job-company').textContent = job.company?.name || 'Unknown';
        document.getElementById('job-location').textContent = '📍 ' + job.location;
        document.getElementById('job-type').textContent = '💼 Tipe: ' + job.job_type;
        document.getElementById('job-deadline').textContent = '⏰ Deadline: ' + new Date(job.deadline).toLocaleDateString('id-ID');
        document.getElementById('job-description').textContent = job.description;
        document.getElementById('job-requirements').textContent = job.requirements || 'Tidak ada requirements khusus';
        
        // Show detail, hide loading
        document.getElementById('job-loading').style.display = 'none';
        document.getElementById('job-detail').style.display = 'block';
        
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('job-loading').innerHTML = '<p style="color:red;">Gagal memuat detail job</p>';
    }
}

// Handle form submission
document.getElementById('apply-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const coverLetter = document.getElementById('cover_letter').value;
    
    try {
        const result = await api.applyJob(jobId, coverLetter);
        
        if (result.success) {
            alert('Lamaran berhasil diajukan!');
            window.location.href = '{{ route("applications.mine") }}';
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
});

// Load job detail on page load
document.addEventListener('DOMContentLoaded', loadJobDetail);
</script>
@endsection
