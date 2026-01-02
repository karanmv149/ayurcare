<x-guest-layout>
    @php
        $role = request('role', 'patient');
    @endphp

    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

        <!-- DESKTOP LAYOUT -->
        <div class="hidden lg:flex w-full max-w-5xl items-center justify-center gap-20">

            <!-- LEFT: AUTH CARD -->
            <div class="w-full max-w-[400px]">
                <div
                    class="bg-white rounded-xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 w-full">

                    <h1 class="text-2xl font-semibold text-gray-900 mb-2 text-center">
                        Welcome Back
                    </h1>
                    <p class="text-sm text-gray-500 mb-8 text-center">
                        Login to access your patient portal
                    </p>

                    <!-- OAuth -->
                    <div class="mb-6">
                        <a href="{{ route('auth.google') }}"
                            class="w-full flex items-center justify-center px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:border-gray-300 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            Continue with Google
                        </a>
                    </div>

                    <div class="relative text-center mb-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <span class="relative px-4 bg-white text-xs text-gray-400 uppercase tracking-wider">or login
                            with email</span>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 border border-green-100">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600 border border-red-100">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-500 mb-1.5 ml-1">Email
                                Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400
                                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                          transition-colors duration-200
                                          @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50/10 @enderror" />
                        </div>

                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-500 mb-1.5 ml-1">Password</label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400
                                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                          transition-colors duration-200
                                          @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50/10 @enderror" />
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-fit px-8 py-3 bg-blue-600 text-white font-medium rounded-lg 
                                            hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/10 
                                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Login
                            </button>
                        </div>
                    </form>

                    <p class="text-sm text-center text-gray-500 mt-8">
                        New to AyurCare?
                        <a href="{{ route('register', ['role' => $role]) }}"
                            class="text-blue-600 hover:text-blue-700 font-medium">Create Policy</a>
                    </p>
                </div>
            </div>

            <!-- RIGHT: BRANDING -->
            <div class="w-full max-w-[400px] pl-10">
                <h1 class="text-6xl font-bold text-gray-900 tracking-tight">
                    Ayur<span class="text-blue-600">Care</span>
                </h1>
            </div>
        </div>

        <!-- MOBILE LAYOUT -->
        <div class="lg:hidden w-full max-w-sm">
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Ayur<span class="text-blue-600">Care</span></h2>
                </div>

                <!-- OAuth -->
                <div class="mb-6">
                    <a href="{{ route('auth.google') }}"
                        class="w-full flex items-center justify-center px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </a>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1 ml-1">EMAIL</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="name@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1 ml-1">PASSWORD</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="••••••••">
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        No account? <a href="{{ route('register', ['role' => $role]) }}"
                            class="text-blue-600 font-medium">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
