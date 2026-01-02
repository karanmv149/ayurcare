@php
    use Illuminate\Support\Str;
@endphp
<nav x-data="{ open: false, categories: false }"
     class="bg-white border-b border-gray-200 w-full sticky top-0 z-50">

    <div class="w-full max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

        <!-- LOGO -->
        <a href="/" class="text-xl font-bold tracking-tight text-gray-900 hover:opacity-90 transition-opacity">
            Ayur<span class="text-blue-600">Care</span>
        </a>

        <!-- DESKTOP NAV (md and up ONLY) -->
        <div class="hidden md:flex items-center gap-8">

            <a href="/doctors" class="nav-link group">
                Explore Doctors
                <span class="block max-w-0 group-hover:max-w-full transition-all duration-300 h-0.5 bg-blue-600"></span>
            </a>

            <!-- Categories Dropdown -->
            <div x-data="{ catOpen: false }" class="relative">
                <button @click="catOpen = !catOpen"
                        class="nav-link flex items-center gap-1 group">
                    Categories
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="catOpen" @click.outside="catOpen = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute right-0 mt-3 w-64 bg-white border border-gray-100 rounded-xl shadow-xl shadow-gray-200/50 p-2 space-y-1 z-50">
                    @foreach ([
                        'Cardiology','Dermatology','Neurology',
                        'Gastroenterology','Pulmonology','Oncology',
                        'Ayurveda','Skin Care','Stress & Sleep'
                    ] as $cat)
                        <a href="/doctors?category={{ Str::slug($cat) }}"
                            class="block text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg px-3 py-2 transition-colors">
                            {{ $cat }}
                        </a>

                    @endforeach
                </div>
            </div>

            @auth
                @if(auth()->user()->isDoctor())
                    <a href="{{ route('doctor.dashboard') }}" class="nav-link">Dashboard</a>
                @elseif(auth()->user()->isPatient())
                    <a href="{{ route('patient.dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    <a href="{{ route('admin.doctors') }}" class="nav-link">Dashboard</a>
                @endif

                <div class="flex items-center gap-4 pl-4 border-l border-gray-200 ml-4">
                    <!-- User Dropdown -->
                    <div x-data="{ userOpen: false }" class="relative">
                        <button @click="userOpen = !userOpen" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden lg:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" :class="{'rotate-180': userOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="userOpen" 
                             @click.outside="userOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-1 z-50 origin-top-right">
                             
                            <!-- Profile Link -->
                            @if(auth()->user()->role === 'doctor')
                                <a href="{{ route('doctor.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile
                                </a>
                            @elseif(auth()->user()->role === 'patient')
                                <a href="{{ route('patient.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile
                                </a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-4 pl-4 border-l border-gray-200">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm shadow-blue-600/20 transition-all focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Account
                    </a>
                </div>
            @endguest

        </div>

        <!-- MOBILE HAMBURGER (FORCED MOBILE ONLY) -->
        <button @click="open = !open"
                class="flex md:hidden items-center justify-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" x-collapse
         class="md:hidden border-t border-gray-100 bg-white w-full absolute top-16 left-0 shadow-lg">
        <div class="px-4 py-6 space-y-4">

            <a href="/doctors" class="mobile-link">Explore Doctors</a>

            <!-- Mobile Categories -->
            <div x-data="{ expanded: false }">
                <button @click="expanded = !expanded" class="mobile-link flex justify-between w-full items-center">
                    Categories
                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="expanded" x-collapse class="pl-4 space-y-2 mt-2 border-l-2 border-gray-100 ml-1">
                    @foreach ([
                        'Cardiology','Dermatology','Neurology',
                        'Gastroenterology','Pulmonology','Oncology',
                        'Ayurveda','Skin Care','Stress & Sleep'
                    ] as $cat)
                        <a href="/doctors?category={{ Str::slug($cat) }}"
                           class="block text-sm text-gray-500 hover:text-blue-600 py-1.5 transition-colors">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            @auth
                @if(auth()->user()->isDoctor())
                    <a href="{{ route('doctor.dashboard') }}" class="mobile-link">Dashboard</a>
                @elseif(auth()->user()->isPatient())
                    <a href="{{ route('patient.dashboard') }}" class="mobile-link">Dashboard</a>
                @else
                    <a href="{{ route('admin.doctors') }}" class="mobile-link">Dashboard</a>
                @endif

                <div class="pt-4 border-t border-gray-100 mt-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-900">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="block text-xs text-gray-500 capitalize">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="pt-4 border-t border-gray-100 mt-4 space-y-3">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm shadow-blue-600/20 transition-all">
                        Create Account
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<style>
    .nav-link {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4B5563; /* Gray-600 */
        transition: color 0.2s ease-in-out;
        position: relative;
    }
    .nav-link:hover, .nav-link:active {
        color: #111827; /* Gray-900 */
    }
    .mobile-link {
        display: block;
        font-size: 1rem;
        font-weight: 500;
        color: #374151; /* Gray-700 */
        padding: 0.5rem 0;
    }
    .mobile-link:hover {
        color: #2563EB; /* Blue-600 */
    }
</style>
