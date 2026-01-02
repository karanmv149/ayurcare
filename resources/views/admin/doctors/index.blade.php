<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Doctor Verification</h1>
            <p class="mt-1 text-sm text-gray-500">Review and manage doctor applications</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pending Approval Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    Pending Requests
                    <span
                        class="ml-2 inline-flex items-center justify-center bg-gray-100 text-gray-600 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        {{ $pendingDoctors->count() }}
                    </span>
                </h2>
            </div>

            @if($pendingDoctors->count() > 0)
                <div class="space-y-4">
                    @foreach($pendingDoctors as $doctor)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 transition-all hover:shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-base font-bold text-gray-900">{{ $doctor->name }}</h3>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Pending Verification
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-1 gap-x-4 text-sm text-gray-600">
                                        <p><span class="font-medium text-gray-500">Email:</span> {{ $doctor->email }}</p>

                                        @if($doctor->doctorProfile)
                                            <p><span class="font-medium text-gray-500">Qualification:</span>
                                                {{ $doctor->doctorProfile->qualification ?? '—' }}</p>
                                            <p><span class="font-medium text-gray-500">Reg No:</span>
                                                {{ $doctor->doctorProfile->registration_number ?? '—' }}</p>
                                            <p><span class="font-medium text-gray-500">Clinic:</span>
                                                {{ $doctor->doctorProfile->clinic_name ?? '—' }}</p>
                                            @if($doctor->doctorProfile->category)
                                                <p><span class="font-medium text-gray-500">Specialty:</span>
                                                    {{ $doctor->doctorProfile->category->name }}</p>
                                            @endif
                                            @if($doctor->doctorProfile->experience_years)
                                                <p><span class="font-medium text-gray-500">Experience:</span>
                                                    {{ $doctor->doctorProfile->experience_years }} years</p>
                                            @endif
                                        @else
                                            <p class="text-amber-600 italic">Profile incomplete</p>
                                        @endif
                                    </div>

                                    @if($doctor->doctorProfile && $doctor->doctorProfile->certificate_path)
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/' . $doctor->doctorProfile->certificate_path) }}"
                                                target="_blank"
                                                class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-700 hover:underline">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                View Certificate
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                @if($doctor->doctorProfile)
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('admin.doctors.reject', $doctor) }}">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 hover:text-red-600 transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Reject
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.doctors.approve', $doctor) }}">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-medium hover:bg-teal-700 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                Approve Doctor
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No pending approvals at this time.</p>
                </div>
            @endif
        </div>

        <!-- Approved Doctors Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    Verified Doctors
                    <span
                        class="ml-2 inline-flex items-center justify-center bg-gray-100 text-gray-600 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        {{ $approvedDoctors->count() }}
                    </span>
                </h2>
            </div>

            @if($approvedDoctors->count() > 0)
                <div class="space-y-4">
                    @foreach($approvedDoctors as $doctor)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 transition-all hover:shadow-sm">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-base font-bold text-gray-900">{{ $doctor->name }}</h3>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-50 text-teal-700 border border-teal-100">
                                            Verified
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-1 gap-x-4 text-sm text-gray-600">
                                        <p><span class="font-medium text-gray-500">Email:</span> {{ $doctor->email }}</p>
                                        @if($doctor->doctorProfile)
                                            <p><span class="font-medium text-gray-500">Qualification:</span>
                                                {{ $doctor->doctorProfile->qualification ?? '—' }}</p>
                                            <p><span class="font-medium text-gray-500">Clinic:</span>
                                                {{ $doctor->doctorProfile->clinic_name ?? '—' }}</p>
                                        @endif
                                    </div>
                                    @if($doctor->doctorProfile && $doctor->doctorProfile->certificate_path)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->doctorProfile->certificate_path) }}"
                                                target="_blank" class="text-sm text-gray-400 hover:text-teal-600 hover:underline">
                                                View Document
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4">
                                    <form method="POST" action="{{ route('admin.doctors.reject', $doctor) }}">
                                        @csrf
                                        <button type="submit"
                                            class="text-sm text-gray-400 hover:text-red-600 font-medium transition-colors"
                                            onclick="return confirm('Are you sure you want to revoke verification for this doctor?')">
                                            Revoke Status
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No verified doctors yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>