@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Edit Paket Game</h2>

        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="game_id" class="block text-gray-700 font-bold mb-2">Game</label>
                <select name="game_id" id="game_id" class="w-full px-3 py-2 border rounded-lg @error('game_id') border-red-500 @enderror">
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', $package->game_id) == $game->id ? 'selected' : '' }}>
                            {{ $game->name }}
                        </option>
                    @endforeach
                </select>
                @error('game_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Paket</label>
                <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}" 
                    class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Harga</label>
                <input type="number" name="price" id="price" value="{{ old('price', $package->price) }}" 
                    class="w-full px-3 py-2 border rounded-lg @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" class="form-checkbox" 
                        {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                    <span class="ml-2">Paket Aktif</span>
                </label>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.packages.index') }}" 
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
