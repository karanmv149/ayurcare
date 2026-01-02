@include('layouts.navigation')
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">

        <!-- Page Header -->
        <div class="mb-12 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-tight">
                Find Your Doctor
            </h1>
            <p class="text-base text-gray-500 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                Connect with verified specialists. Filter by category or search by name to find the right care for your
                needs.
            </p>
        </div>

        <!-- Filters (Polished) -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-10 shadow-sm">
            <form method="GET" action="{{ route('doctors.index') }}" class="flex flex-col md:flex-row gap-5 items-end">

                <!-- Search Input -->
                <div class="w-full md:flex-[2]">
                    <label for="search"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                        Search Doctors
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="e.g. Dr. Sharma"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-100 rounded-xl text-sm text-gray-900 placeholder-gray-400
                                      focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all hover:border-gray-300">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="w-full md:flex-1">
                    <label for="category"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                        Specialty
                    </label>
                    <div class="relative">
                        <select name="category" id="category"
                            class="w-full pl-4 pr-10 py-2.5 border border-gray-100 rounded-xl text-sm text-gray-900
                                       focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none bg-white transition-all cursor-pointer hover:border-gray-300">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="w-full md:w-auto flex items-center gap-3">
                    <button type="submit"
                        class="h-[42px] px-6 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply
                    </button>

                    @if(request()->hasAny(['category', 'search']))
                        <a href="{{ route('doctors.index') }}"
                            class="h-[42px] flex items-center justify-center px-5 border border-gray-200 bg-gray-50 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-100 hover:text-gray-900 transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="mb-8 flex items-center justify-between">
            <p class="text-sm text-gray-500">
                Showing <span class="font-semibold text-gray-900">{{ $doctors->count() }}</span>
                {{ $doctors->count() === 1 ? 'specialist' : 'specialists' }}
            </p>
        </div>

        <!-- Doctors Grid -->
        @if($doctors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($doctors as $doctor)
                    <div
                        class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 group">
                        <!-- Card Header -->
                        <div class="flex items-start justify-between mb-6">
                            <!-- Avatar -->
                            <div
                                class="h-14 w-14 rounded-full bg-blue-50 flex items-center justify-center border border-blue-100 text-blue-600 font-bold text-xl group-hover:scale-105 transition-transform duration-300">
                                {{ strtoupper(substr($doctor->name, 0, 1)) }}
                            </div>

                            <!-- Verified Badge -->
                            @if($doctor->doctorProfile && $doctor->doctorProfile->is_verified)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Verified
                                </span>
                            @endif
                        </div>

                        <!-- Doctor Info -->
                        <div class="mb-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('doctors.show', $doctor->id) }}">
                                    {{ $doctor->name }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-500 font-medium mb-3">
                                @if($doctor->doctorProfile)
                                    {{ $doctor->doctorProfile->qualification ?? 'Medical Practitioner' }}
                                    @if($doctor->doctorProfile->category)
                                        <span class="text-gray-300 mx-1">•</span>
                                        <span class="text-blue-600">{{ $doctor->doctorProfile->category->name }}</span>
                                    @endif
                                @else
                                    Doctor
                                @endif
                            </p>

                            <!-- Meta Info -->
                            @if($doctor->doctorProfile)
                                <div class="flex flex-col gap-1.5">
                                    @if($doctor->doctorProfile->clinic_name)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $doctor->doctorProfile->clinic_name }}
                                        </div>
                                    @endif
                                    @if($doctor->doctorProfile->experience_years)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $doctor->doctorProfile->experience_years }} years experience
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <!-- Rating -->
                            <div>
                                @if($doctor->reviews_count > 0)
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400 text-sm">★</span>
                                        <span
                                            class="text-sm font-semibold text-gray-900">{{ number_format($doctor->average_rating, 1) }}</span>
                                        <span class="text-xs text-gray-400 ml-1">({{ $doctor->reviews_count }})</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No ratings</span>
                                @endif
                            </div>

                            <a href="{{ route('doctors.show', $doctor->id) }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
                                View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white border border-gray-100 rounded-2xl p-16 text-center shadow-sm">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-6 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No doctors found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    We couldn't find any specialist matching your search. Try adjusting your filters.
                </p>
                <a href="{{ route('doctors.index') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-colors">
                    Clear all filters
                </a>
            </div>
        @endif
    </div>
</x-guest-layout>