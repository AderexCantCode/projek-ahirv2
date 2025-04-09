@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Edit Game</h2>

        <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Game</label>
                <input type="text" name="name" id="name" value="{{ old('name', $game->name) }}" 
                    class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4" 
                    class="w-full px-3 py-2 border rounded-lg @error('description') border-red-500 @enderror">{{ old('description', $game->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Gambar</label>
                @if($game->image)
                    <img src="{{ asset($game->image) }}" alt="{{ $game->name }}" class="w-32 h-32 object-cover mb-2">
                @endif
                <input type="file" name="image" id="image" 
                    class="w-full px-3 py-2 border rounded-lg @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" class="form-checkbox" 
                        {{ old('is_active', $game->is_active) ? 'checked' : '' }}>
                    <span class="ml-2">Game Aktif</span>
                </label>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.games.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
