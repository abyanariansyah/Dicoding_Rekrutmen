@extends('layouts.professional')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Buat Lowongan Baru</h1>
        <p class="text-gray-600 mb-6">Lengkapi semua informasi lowongan dengan detail dan menarik.</p>

        <form method="POST" action="{{ route('admin.jobs.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Lowongan</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Senior Backend Developer" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Pekerjaan</label>
                <textarea name="description" rows="6" placeholder="Jelaskan tentang pekerjaan ini..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Persyaratan</label>
                <textarea name="requirements" rows="6" placeholder="- Minimal 5 tahun pengalaman&#10;- Mahir dengan teknologi X&#10;- Kemampuan komunikasi yang baik" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('requirements') }}</textarea>
                @error('requirements')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Jakarta, Indonesia" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('location')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Pekerjaan</label>
                    <select name="job_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="Full-time" {{ old('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ old('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Contract" {{ old('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Internship" {{ old('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                        <option value="Freelance" {{ old('job_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('job_type')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Level Pengalaman</label>
                    <select name="experience_level" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="Entry Level" {{ old('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                        <option value="Mid Level" {{ old('experience_level') == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                        <option value="Senior" {{ old('experience_level') == 'Senior' ? 'selected' : '' }}>Senior</option>
                        <option value="Expert" {{ old('experience_level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @error('experience_level')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('deadline')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gaji Minimum</label>
                    <input type="number" name="salary_min" value="{{ old('salary_min') }}" placeholder="15000000" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('salary_min')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gaji Maksimum</label>
                    <input type="number" name="salary_max" value="{{ old('salary_max') }}" placeholder="25000000" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('salary_max')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    Buat Lowongan
                </button>
                <a href="{{ route('admin.jobs.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
