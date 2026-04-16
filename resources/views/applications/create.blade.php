@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Ajukan Lamaran</h1>
    <p>Lowongan: <strong>{{ $job->title }}</strong></p>
    <p>{{ $job->description }}</p>
    <p>Deadline: {{ $job->deadline->format('d M Y') }}</p>

    <form method="POST" action="{{ route('jobs.apply.store', $job) }}">
        @csrf
        <div class="field">
            <label for="note">Keterangan Tambahan</label>
            <textarea id="note" name="note" class="textarea" placeholder="Tuliskan keterangan jika perlu.">{{ old('note') }}</textarea>
        </div>
        <button type="submit" class="button">Ajukan Lamaran</button>
    </form>
</div>
@endsection
