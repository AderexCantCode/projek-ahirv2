@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md" data-aos="fade-up">
        <div class="text-center">
            <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Transaksi Berhasil!
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Terima kasih telah melakukan pembelian di MidTopUp
            </p>
        </div>

        <div class="mt-8 space-y-6">
            <div class="text-center">
                <a href="{{ route('transactions.history') }}" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-history mr-2"></i>
                    Lihat Riwayat Transaksi
                </a>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
