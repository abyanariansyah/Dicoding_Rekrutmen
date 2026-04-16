@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Lamaran Saya</h1>
    <p>Melihat status lamaran yang pernah diajukan.</p>

    @if($applications->isEmpty())
        <p>Belum ada lamaran.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Diajukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->note ?? '-' }}</td>
                        <td>{{ $application->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
