@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-indigo-600 mb-4">Top Up Game</h1>
        <p class="text-gray-600 text-lg">Proses Cepat dan Aman</p>
    </div>

    <!-- Game List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($games as $game)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-105">
            <div class="aspect-w-16 aspect-h-9">
                <img src="{{ asset('/storage/games/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-48 object-cover">
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-gray-800">{{ $game->name }}</h3>
                <p class="text-gray-600 mb-6 text-sm leading-relaxed">{{ Str::limit($game->description, 100) }}</p>
                <button onclick="showPackages({{ $game->id }})" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                    Pilih Paket
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Packages Modals -->
    @foreach($games as $game)
    <div id="packages-modal-{{ $game->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-xl p-6 max-w-2xl mx-auto mt-20">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">{{ $game->name }} - Paket</h3>
                <button onclick="hidePackages({{ $game->id }})" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($game->packages->where('is_active', true) as $package)
                <a href="{{ route('transactions.create', $package->id) }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="font-bold text-gray-800">{{ $package->name }}</div>
                    <div class="text-indigo-600 font-bold mt-2">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                </a>
                @empty
                <p class="text-gray-500 col-span-2 text-center py-6">Belum ada paket tersedia</p>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach

    <!-- Features -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-xl shadow-lg text-center">
            <i class="fas fa-bolt text-3xl text-indigo-600 mb-4"></i>
            <h3 class="text-xl font-bold mb-3">Proses Instan</h3>
            <p class="text-gray-600">Diproses setelah pembayaran</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg text-center">
            <i class="fas fa-shield-alt text-3xl text-indigo-600 mb-4"></i>
            <h3 class="text-xl font-bold mb-3">Aman</h3>
            <p class="text-gray-600">Pembayaran terpercaya</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg text-center">
            <i class="fas fa-headset text-3xl text-indigo-600 mb-4"></i>
            <h3 class="text-xl font-bold mb-3">Layanan 24/7</h3>
            <p class="text-gray-600">Siap membantu</p>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
        <h2 class="text-2xl font-bold mb-6">Metode Pembayaran</h2>
        <div class="flex justify-center items-center gap-8">
            <img src="{{ asset('storage/image/payments/BCA.png') }}" alt="BCA" class="h-10">
            <img src="{{ asset('storage/image/payments/Mandiri.png') }}" alt="Mandiri" class="h-10">
            <img src="{{ asset('storage/image/payments/gopay.png') }}" alt="GoPay" class="h-10">
            <img src="{{ asset('storage/image/payments/ovo.png') }}" alt="OVO" class="h-10">
        </div>
    </div>
</div>

<script>
function showPackages(gameId) {
    document.getElementById('packages-modal-' + gameId).classList.remove('hidden');
}

function hidePackages(gameId) {
    document.getElementById('packages-modal-' + gameId).classList.add('hidden');
}
</script>
@endsection
