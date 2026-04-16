@extends('layouts.professional')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">{{ $company ? 'Edit Profil Perusahaan' : 'Buat Profil Perusahaan' }}</h1>
        <p class="text-gray-600 mb-6">Informasi perusahaan diperlukan sebelum Anda dapat membuat lowongan.</p>

        <form method="POST" action="{{ route('company.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Perusahaan</label>
                <input type="text" name="name" value="{{ old('name', $company?->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Perusahaan</label>
                <textarea name="description" rows="5" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $company?->description) }}</textarea>
                @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                    <input type="url" name="website" value="{{ old('website', $company?->website) }}" placeholder="https://example.com" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('website')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $company?->location) }}" placeholder="Jakarta, Indonesia" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('location')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Industri</label>
                    <select name="industry" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Industri</option>
                        <option value="Technology" {{ old('industry', $company?->industry) == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Marketing" {{ old('industry', $company?->industry) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Finance" {{ old('industry', $company?->industry) == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Healthcare" {{ old('industry', $company?->industry) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Education" {{ old('industry', $company?->industry) == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Retail" {{ old('industry', $company?->industry) == 'Retail' ? 'selected' : '' }}>Retail</option>
                        <option value="Other" {{ old('industry', $company?->industry) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('industry')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran Perusahaan</label>
                    <select name="company_size" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Ukuran</option>
                        <option value="1-10" {{ old('company_size', $company?->company_size) == '1-10' ? 'selected' : '' }}>1-10 karyawan</option>
                        <option value="11-50" {{ old('company_size', $company?->company_size) == '11-50' ? 'selected' : '' }}>11-50 karyawan</option>
                        <option value="50-100" {{ old('company_size', $company?->company_size) == '50-100' ? 'selected' : '' }}>50-100 karyawan</option>
                        <option value="100-500" {{ old('company_size', $company?->company_size) == '100-500' ? 'selected' : '' }}>100-500 karyawan</option>
                        <option value="500+" {{ old('company_size', $company?->company_size) == '500+' ? 'selected' : '' }}>500+ karyawan</option>
                    </select>
                    @error('company_size')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    {{ $company ? 'Perbarui Profil' : 'Buat Profil' }}
                </button>
                <a href="{{ route('admin.jobs.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
