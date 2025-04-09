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
                <h2 class="font-bold text-center text-2xl mb-5">Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-5">
                        <label for="email" class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
                        <input id="email" type="email" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="text-red-500 text-xs" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password" class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input id="password" type="password" class="border rounded-lg px-3 py-2 mt-1 mb-2 text-sm w-full @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="text-red-500 text-xs" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <div class="flex items-center">
                            <input class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-600" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="transition duration-200 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 focus:shadow-sm focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        Sign In
                    </button>
                </form>
            </div>
            <div class="py-5 px-5">
                <div class="grid grid-cols-1 gap-1">
                    <div class="text-center">
                        <p class="text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Register</a></p>
                        @if (Route::has('password.request'))
                            <p class="text-sm mt-2">
                                <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-gray-600">Forgot Your Password?</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection