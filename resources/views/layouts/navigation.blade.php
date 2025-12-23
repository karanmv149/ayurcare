<nav class="bg-white border-b border-gray-300 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

        <div class="font-bold text-lg">
            <a href="{{ auth()->check() ? route('home') : route('welcome') }}">
                AyurCare
            </a>
        </div>

        <div class="flex gap-4 items-center">

            @auth
                @if(auth()->user()->role === 'doctor')
                    <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
                    <a href="{{ route('doctor.verify') }}">Verification</a>
                @elseif(auth()->user()->role === 'patient')
                    <a href="{{ route('patient.dashboard') }}">Dashboard</a>
                    <a href="{{ route('patient.consultations') }}">Consultations</a>
                    <a href="{{ route('patient.careplans') }}">Care Plans</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth

        </div>
    </div>
</nav>
