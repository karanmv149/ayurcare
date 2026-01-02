@include('layouts.navigation')
<x-guest-layout>

    <!-- HERO SECTION -->
    <section class="relative bg-white pt-20 pb-32 overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-50"></div>
            <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50/50 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-1/3 h-full bg-gradient-to-r from-blue-50/50 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wide mb-8 animate-fade-in-up">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Accepting New Patients
            </div>

            <!-- Headline -->
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-gray-900 mb-6 leading-tight max-w-5xl mx-auto animate-fade-in-up delay-100">
                Healthcare that revolves <br class="hidden md:block" />
                around <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">you.</span>
            </h1>

            <!-- Subheadline -->
            <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed animate-fade-in-up delay-200">
                Experience the perfect blend of modern medicine and holistic Ayurveda. 
                Connect with top-rated specialists for video consultations and personalized care plans.
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up delay-300">
                <a href="{{ route('register') }}"
                    class="min-w-[200px] px-8 py-4 bg-blue-600 text-white rounded-xl font-semibold shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-0.5 transition-all duration-200">
                    Get Started
                </a>
                <a href="{{ route('doctors.index') }}"
                    class="min-w-[200px] px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 flex items-center justify-center gap-2 group">
                    Find a Doctor
                    <svg class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Metrics / Social Proof -->
            <div class="mt-16 pt-8 border-t border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto animate-fade-in-up delay-500">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900">500+</h3>
                    <p class="text-sm text-gray-500 font-medium">Verified Doctors</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900">10k+</h3>
                    <p class="text-sm text-gray-500 font-medium">Happy Patients</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900">24/7</h3>
                    <p class="text-sm text-gray-500 font-medium">Instant Support</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900">4.9/5</h3>
                    <p class="text-sm text-gray-500 font-medium">Average Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-base font-semibold text-blue-600 uppercase tracking-wide mb-2">Why Choose AyurCare</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Complete healthcare at your fingertips</h3>
                <p class="text-gray-500 text-lg">We combine technology with care to provide seamless medical experiences.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">HD Video Consultations</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Connect face-to-face with specialists from the comfort of your home. High-quality secure video calls.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Digital Prescriptions</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Receive signed digital prescriptions and care plans immediately after your consultation.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">24/7 Availability</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Our network of doctors ensures coverage across time zones, so you can get help when you need it.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- TOP DOCTORS TEASER -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Meet Our Specialists</h2>
                    <p class="text-gray-500">Highly qualified professionals ready to help you.</p>
                </div>
                <a href="{{ route('doctors.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-1 group">
                    Browse All Doctors <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            @if($doctors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($doctors->take(3) as $doctor)
                        <div class="group bg-white rounded-2xl border border-gray-200 p-6 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-2xl font-bold text-gray-500 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    {{ substr($doctor->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">{{ $doctor->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $doctor->doctorProfile->category->name ?? 'Specialist' }}</p>
                                    @if($doctor->doctorProfile && $doctor->doctorProfile->is_verified)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 mt-2 rounded-full bg-green-50 text-green-700 text-xs font-medium border border-green-100">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-50 flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ $doctor->doctorProfile->experience_years ?? 0 }}+ Years Exp.</span>
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="text-blue-600 font-medium hover:underline">View Profile</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <p class="text-gray-500">No fully verified doctors available to showcase yet.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="relative py-24 overflow-hidden">
        <!-- Background with Premium Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900"></div>
        
        <!-- Animated Background Effects -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
        </div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: linear-gradient(#ffffff 1px, transparent 1px), linear-gradient(90deg, #ffffff 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 tracking-tight">
                Ready to prioritize your health?
            </h2>
            <p class="text-blue-100 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
                Join thousands of patients who trust AyurCare for their medical and Ayurvedic needs.
                Start your journey to better health today.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                <a href="{{ route('register') }}" 
                   class="w-full sm:w-auto px-8 py-4 bg-white text-blue-900 rounded-xl font-bold text-lg hover:bg-blue-50 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/20 transition-all duration-300">
                    Get Started for Free
                </a>
                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto px-8 py-4 bg-blue-800/50 backdrop-blur-sm border border-blue-700/50 text-white rounded-xl font-bold text-lg hover:bg-blue-800 hover:border-blue-600 transition-all duration-300">
                    Sign In to Account
                </a>
            </div>
            
            <p class="mt-8 text-sm text-blue-300/80">
                No credit card required for sign up.
            </p>
        </div>
    </section>

    @include('layouts.footer')

</x-guest-layout>