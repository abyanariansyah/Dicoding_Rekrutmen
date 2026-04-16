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
}
.btn-lamar:hover { background: #dbeafe; }
</style>

<div class="max-w-6xl mx-auto p-6" style="background:#f3f4f6;min-height:100vh">
    <div class="grid md:grid-cols-2 gap-4">
        @foreach($jobs as $job)
        <div class="job-card">

            {{-- Logo --}}
            <div class="logo-box">
                @if($job->company?->logo)
                    <img src="{{ $job->company->logo }}" alt="{{ $job->company->name }}">
                @else
                    {{ strtoupper(substr($job->company?->name ?? '?', 0, 2)) }}
                @endif
            </div>

            {{-- Nama perusahaan --}}
            @if($job->company)
                <div class="co-name">{{ $job->company->name }}</div>
                <div class="verified">
                    <svg width="13" height="13" viewBox="0 0 13 13">
                        <circle cx="6.5" cy="6.5" r="6.5" fill="#16a34a"/>
                        <path d="M3.8 6.5l2 2 3.4-3.8" stroke="#fff" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                    Verified Employer
                </div>
            @endif

            {{-- Judul pekerjaan --}}
            <div class="job-title">{{ $job->title }}</div>

            {{-- Tags --}}
            <div class="tags">
                @if($job->is_urgent ?? false)
                    <span class="tag tag-urgent">Urgent</span>
                @endif
                @if($job->is_premium ?? false)
                    <span class="tag tag-premium">Premium</span>
                @endif
                <span class="tag tag-type">{{ $job->job_type }}</span>
                <span class="tag">{{ $job->experience_level }}</span>
                @if($job->category)
                    <span class="tag">{{ $job->category->name }}</span>
                @endif
            </div>

            <hr class="divider">

            {{-- Lokasi --}}
            <div class="location">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M6 1a3.5 3.5 0 013.5 3.5C9.5 7.5 6 11 6 11S2.5 7.5 2.5 4.5A3.5 3.5 0 016 1z" fill="#9ca3af"/>
                    <circle cx="6" cy="4.5" r="1.2" fill="#fff"/>
                </svg>
                {{ $job->location }}
            </div>

            {{-- Gaji + waktu --}}
            <div class="salary-row">
                @if($job->salary_min && $job->salary_max)
                    <span class="salary">
                        Rp {{ number_format($job->salary_min,0,',','.') }} –
                        Rp {{ number_format($job->salary_max,0,',','.') }}
                    </span>
                @endif
                <span class="time">{{ $job->created_at->diffForHumans() }}</span>
            </div>

            {{-- Tombol --}}
            <a href="{{ route('jobs.apply', $job) }}" class="btn-lamar">Lamar →</a>

        </div>
        @endforeach
    </div>
</div>
@endsection