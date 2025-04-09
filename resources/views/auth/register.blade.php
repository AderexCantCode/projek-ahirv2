@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    'poppins': ['Poppins', 'sans-serif'],
                },
            }
        }
    }
</script>

<div class="min-h-screen flex flex-col justify-center sm:py-12">
    <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
        <div class="bg-white shadow w-full rounded-lg divide-gray-200" data-aos="fade-up">
            <div class="px-5 py-7">
                <h2 class="font-bold text-center text-2xl mb-5">Register</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="font-semibold text-sm text-gray-600 pb-1 block">Name</label>
                        <input id="name" type="text" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="text-red-500 text-xs" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="email" class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
                        <input id="email" type="email" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="text-red-500 text-xs" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password" class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input id="password" type="password" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="text-red-500 text-xs" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password-confirm" class="font-semibold text-sm text-gray-600 pb-1 block">Confirm Password</label>
                        <input id="password-confirm" type="password" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="transition duration-200 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 focus:shadow-sm focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        Register
                    </button>
                </form>
            </div>
            <div class="py-5 px-5">
                <div class="grid grid-cols-1 gap-1">
                    <div class="text-center">
                        <p class="text-sm">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection