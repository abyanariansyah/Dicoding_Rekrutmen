@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <div>
            <h1>Kelola Lowongan</h1>
            <p>Buat, ubah, dan hapus lowongan pekerjaan.</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="button">Buat Lowongan</a>
    </div>

    @if($jobs->isEmpty())
        <p>Tidak ada lowongan saat ini.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->deadline->format('d M Y') }}</td>
                        <td style="display:flex; gap:10px; flex-wrap:wrap;">
                            <a href="{{ route('admin.jobs.edit', $job) }}" class="button button-small button-muted">Edit</a>
                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Hapus lowongan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-small button-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
