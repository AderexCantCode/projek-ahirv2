@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6" data-aos="fade-up">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Checkout</h1>
            
            <div class="mb-6 p-4 bg-gray-50 rounded-md">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $package->game->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $package->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                
                <div class="mb-4">
                    <label for="game_username" class="block text-sm font-medium text-gray-700">Username Game</label>
                    <input type="text" name="game_username" id="game_username" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label for="game_user_id" class="block text-sm font-medium text-gray-700">ID Game</label>
                    <input type="text" name="game_user_id" id="game_user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">Opsional, tergantung game</p>
                </div>
                
                <div class="mb-6">
                    <label for="game_server" class="block text-sm font-medium text-gray-700">Server Game</label>
                    <input type="text" name="game_server" id="game_server" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">Opsional, tergantung game</p>
                </div>
                
                <div class="flex items-center justify-between border-t pt-6">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 transition">
                        <i class="fas fa-credit-card mr-2"></i> Lanjut ke Pembayaran
                    </button>
                    <p class="text-center mt-2 text-sm text-gray-500">Pembayaran akan diproses melalui Midtrans</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection