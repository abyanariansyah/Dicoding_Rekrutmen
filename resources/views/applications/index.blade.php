@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Semua Lamaran</h1>
    <p>Kelola status lamaran yang masuk dari pelamar.</p>

    @if($applications->isEmpty())
        <p>Belum ada lamaran.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Pelamar</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->user->name }}<br><small>{{ $application->user->email }}</small></td>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->note ?? '-' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                                @csrf
                                <div class="field">
                                    <select name="status" class="select">
                                        <option value="Pending" {{ $application->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Diterima" {{ $application->status === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Ditolak" {{ $application->status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <input type="text" name="note" class="input" value="{{ old('note', $application->note) }}" placeholder="Keterangan (opsional)">
                                </div>
                                <button type="submit" class="button button-small">Perbarui</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
