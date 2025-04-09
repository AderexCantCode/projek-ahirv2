@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Checkout</h2>

            @if($transactions->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada transaksi yang menunggu pembayaran</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Kembali ke Beranda
                    </a>
                </div>
            @else
                @foreach($transactions as $transaction)
                <div class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $transaction->gamesPackage->game->name }}</h3>
                            <p class="text-gray-600">{{ $transaction->gamesPackage->name }}</p>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">ID Transaksi: {{ $transaction->transaction_id }}</p>
                                <p class="text-sm text-gray-500">Username: {{ $transaction->game_username }}</p>
                                @if($transaction->game_user_id)
                                    <p class="text-sm text-gray-500">User ID: {{ $transaction->game_user_id }}</p>
                                @endif
                                @if($transaction->game_server)
                                    <p class="text-sm text-gray-500">Server: {{ $transaction->game_server }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            @if($transaction->discount_amount > 0)
                                <p class="text-sm text-red-500">-Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</p>
                                <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            @endif
                            <button 
                                class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                                id="pay-button-{{ $transaction->id }}"
                                data-token="{{ $transaction->snap_token }}"
                                onclick="pay('{{ $transaction->snap_token }}')"
                            >
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script type="text/javascript">
    function pay(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = '{{ route("transactions.success") }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route("transactions.history") }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal, silakan coba lagi');
            },
            onClose: function() {
                alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran');
            }
        });
    }
</script>
@endsection