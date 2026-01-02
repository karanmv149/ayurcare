<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- PAGE HEADER -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Patient Dashboard
                </h1>
                <p class="text-base text-gray-500">
                    Welcome back, {{ auth()->user()->name }}. Manage your health journey here.
                </p>
            </div>

            <a href="{{ route('doctors.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/20">
                Book New Consultation
            </a>
        </div>

        <!-- ACTIVE VIDEO CALL ALERT -->
        @if(isset($activeVideoConsultation))
            <div
                class="mb-8 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/30 flex flex-col md:flex-row items-center justify-between gap-6 animate-fade-in-down">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm animate-pulse">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-1">
                            Video Consultation Ready
                        </h2>
                        <p class="text-blue-100 text-sm">
                            Dr. {{ $activeVideoConsultation->doctor->name ?? 'Your Doctor' }} has started the video session.
                        </p>
                    </div>
                </div>
                <a href="{{ route('consultations.video', $activeVideoConsultation->id) }}"
                    class="whitespace-nowrap px-8 py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-lg shadow-black/10 flex items-center gap-2">
                    <span>Join Call Now</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif

        <!-- ACTIVE QUEUE STATUS -->
        @if(isset($queueItem))
            <div
                class="mb-10 bg-white border border-blue-100 rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(37,99,235,0.1)] relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 text-center md:text-left">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            Live Queue Status
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Waiting for Dr. {{ $queueItem->doctor->name }}
                        </h2>
                        <p class="text-gray-600 max-w-lg">
                            Please stay available. The doctor will review your file shortly.
                        </p>

                        @if($queueItem->status === 'in_progress')
                            <div
                                class="mt-4 p-4 bg-green-50 text-green-800 rounded-xl border border-green-100 flex items-center justify-center md:justify-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">It's your turn! Session in progress.</span>
                                @if(isset($activeVideoConsultation))
                                    <a href="{{ route('consultations.video', $activeVideoConsultation->id) }}"
                                        class="ml-auto inline-flex items-center px-4 py-1.5 bg-green-600 text-white text-sm font-bold rounded-lg shadow hover:bg-green-700 animate-pulse">
                                        Join Video
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex flex-col items-center justify-center bg-white border border-gray-100 rounded-2xl p-6 shadow-sm min-w-[160px]">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Your Position</p>
                        <span class="text-5xl font-bold text-blue-600 tracking-tighter">
                            #{{ $queueItem->position }}
                        </span>
                        <p class="mt-2 text-sm font-medium text-gray-500 capitalize bg-gray-50 px-3 py-1 rounded-full">
                            {{ str_replace('_', ' ', $queueItem->status) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- DASHBOARD NAVIGATION CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- My Consultations -->
            <a href="{{ route('patient.consultations') }}"
                class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                    My Consultations
                </h2>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                    View your consultation history, check status, and access consultation messages.
                </p>
                <div class="flex items-center text-sm font-medium text-blue-600">
                    View History <span class="ml-1 group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            <!-- Care Plans -->
            <a href="{{ route('patient.careplans') }}"
                class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-green-300 hover:shadow-lg hover:shadow-green-500/5 transition-all duration-300">
                <div
                    class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                    My Care Plans
                </h2>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                    Access your personalized treatment plans, dietary advice, and wellness goals.
                </p>
                <div class="flex items-center text-sm font-medium text-green-600">
                    View Plans <span class="ml-1 group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            <!-- Find Doctor (Quick Link) -->
            <a href="{{ route('doctors.index') }}"
                class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-indigo-300 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div
                    class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                    Find Specialists
                </h2>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                    Browse our list of verified doctors and book a new consultation today.
                </p>
                <div class="flex items-center text-sm font-medium text-indigo-600">
                    Search Now <span class="ml-1 group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>