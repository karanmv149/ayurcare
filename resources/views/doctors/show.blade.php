@include('layouts.navigation')
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
        <!-- Flash Messages -->
        @if(session('success'))
            <div
                class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">

            <!-- LEFT: Doctor Identity & Details -->
            <div class="w-full lg:flex-[2]">

                <!-- Header Card -->
                <div
                    class="bg-white border border-gray-100 rounded-3xl p-8 mb-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex flex-col md:flex-row items-start gap-6">
                        <!-- Avatar -->
                        <div
                            class="w-24 h-24 rounded-full bg-blue-50 border-2 border-white shadow-sm flex items-center justify-center shrink-0">
                            <span class="text-3xl font-bold text-blue-600">
                                {{ strtoupper(substr($doctor->name, 0, 1)) }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 w-full">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                                    {{ $doctor->name }}
                                </h1>
                                @if($doctor->doctorProfile && $doctor->doctorProfile->is_verified)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Verified
                                    </span>
                                @endif
                            </div>

                            <p class="text-lg text-gray-600 mb-4 font-medium">
                                @if($doctor->doctorProfile)
                                    {{ $doctor->doctorProfile->qualification ?? 'Medical Practitioner' }}
                                    @if($doctor->doctorProfile->category)
                                        <span class="text-gray-300 mx-2">•</span>
                                        <span class="text-blue-600">{{ $doctor->doctorProfile->category->name }}</span>
                                    @endif
                                @else
                                    Doctor
                                @endif
                            </p>

                            <!-- Meta Grid -->
                            @if($doctor->doctorProfile)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-50">

                                    @if($doctor->doctorProfile->experience_years)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">
                                                    Experience</p>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $doctor->doctorProfile->experience_years }} Years</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($doctor->doctorProfile->clinic_name)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Clinic
                                                </p>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $doctor->doctorProfile->clinic_name }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($doctor->doctorProfile->registration_number)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Medical
                                                    Reg.</p>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $doctor->doctorProfile->registration_number }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bio & Details -->
                @if($doctor->doctorProfile && $doctor->doctorProfile->bio)
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">About Doctor</h2>
                        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed">
                            <p>{{ $doctor->doctorProfile->bio }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- RIGHT: Booking Card -->
            <div class="w-full lg:flex-1">
                <div class="bg-white border border-gray-200 rounded-3xl p-8 shadow-lg sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Book Consultation</h3>

                    @if($doctor->doctorProfile && $doctor->doctorProfile->consultation_fee)
                        <div class="flex justify-between items-center mb-8 pb-8 border-b border-gray-100">
                            <span class="text-gray-600">Consultation Fee</span>
                            <span
                                class="text-2xl font-bold text-gray-900">₹{{ number_format($doctor->doctorProfile->consultation_fee) }}</span>
                        </div>
                    @endif

                    <!-- CTA Logic -->
                    @auth
                        @if(auth()->user()->isPatient())
                            @if($doctor->doctorProfile)
                                <button onclick="openBookingModal()"
                                    class="w-full py-4 bg-blue-600 text-white rounded-xl font-semibold shadow-md shadow-blue-600/20 hover:bg-blue-700 hover:shadow-blue-600/30 transition-all transform active:scale-[0.98]">
                                    Book Appointment
                                </button>
                                <p class="text-xs text-center text-gray-500 mt-4">
                                    Instant confirmation • Secure booking
                                </p>
                            @else
                                <button disabled
                                    class="w-full py-4 bg-gray-100 text-gray-400 rounded-xl font-semibold cursor-not-allowed">
                                    Profile Unavailable
                                </button>
                            @endif
                        @elseif(auth()->user()->isDoctor())
                            @if(auth()->id() === $doctor->id)
                                <a href="{{ route('doctor.dashboard') }}"
                                    class="block w-full py-4 bg-gray-900 text-white rounded-xl font-semibold text-center hover:bg-gray-800 transition-colors">
                                    Go to Dashboard
                                </a>
                            @else
                                <div class="p-4 bg-gray-50 rounded-xl text-center">
                                    <p class="text-sm text-gray-500">Doctors cannot book appointments with other doctors.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center">
                                <p class="text-sm text-gray-500 mb-4">Admin accounts cannot book.</p>
                                <a href="{{ route('register', ['role' => 'patient']) }}"
                                    class="block w-full py-4 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                                    Create Patient Account
                                </a>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('register', ['role' => 'patient']) }}"
                            class="block w-full py-4 bg-blue-600 text-white rounded-xl font-semibold text-center shadow-md shadow-blue-600/20 hover:bg-blue-700 transition-all">
                            Login to Book
                        </a>
                        <p class="text-xs text-center text-gray-500 mt-4">
                            New? <a href="{{ route('register', ['role' => 'patient']) }}"
                                class="text-blue-600 hover:underline">Create an account</a>
                        </p>
                    @endauth

                </div>
            </div>

        </div>
    </div>

    <!-- Booking Modal (for Patients) -->
    @auth
        @if(auth()->user()->isPatient() && $doctor->doctorProfile)
            <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4"
                role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description"
                onclick="closeBookingModal(event)">
                <div class="bg-white rounded-2xl max-w-2xl w-full p-8 shadow-xl" onclick="event.stopPropagation()"
                    id="modal-content">
                    <div class="flex justify-between items-center mb-6">
                        <h2 id="modal-title" class="text-2xl font-semibold text-gray-900">
                            Book Consultation with {{ $doctor->name }}
                        </h2>
                        <button onclick="closeBookingModal(event)" class="text-gray-400 hover:text-gray-600 transition-colors"
                            aria-label="Close modal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <p id="modal-description" class="text-sm text-gray-600 mb-6">
                        Please describe your symptoms, concerns, or reason for consultation. The doctor will review your
                        request.
                    </p>

                    <form method="POST" action="{{ route('doctors.book', $doctor->id) }}" class="space-y-6" id="bookingForm"
                        onsubmit="handleFormSubmit(event)">
                        @csrf

                        <div>
                            <label for="chief_complaint" class="block text-sm font-medium text-gray-700 mb-2">
                                Chief Complaint <span class="text-red-500">*</span>
                            </label>
                            <textarea id="chief_complaint" name="chief_complaint" rows="6" required minlength="10"
                                maxlength="1000"
                                placeholder="Please describe your symptoms, concerns, or reason for consultation..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none @error('chief_complaint') border-red-500 @enderror"
                                aria-describedby="chief_complaint-error chief_complaint-help">{{ old('chief_complaint') }}</textarea>
                            <p id="chief_complaint-help" class="mt-1 text-xs text-gray-500">
                                Minimum 10 characters, maximum 1000 characters
                            </p>
                            @error('chief_complaint')
                                <p id="chief_complaint-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" id="submitButton"
                                class="flex-1 px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">Submit Request</span>
                                <span id="submitLoading" class="hidden">Submitting...</span>
                            </button>
                            <button type="button" onclick="closeBookingModal(event)"
                                class="flex-1 px-6 py-3 border border-gray-300 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Auto-open modal if there are validation errors
                @if($errors->has('chief_complaint') || old('chief_complaint'))
                    document.addEventListener('DOMContentLoaded', function () {
                        openBookingModal();
                    });
                @endif

                    function openBookingModal() {
                        const modal = document.getElementById('bookingModal');
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';

                        // Focus on textarea for accessibility
                        setTimeout(() => {
                            document.getElementById('chief_complaint').focus();
                        }, 100);
                    }

                function closeBookingModal(event) {
                    event.preventDefault();
                    const modal = document.getElementById('bookingModal');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = 'auto';

                    // Clear form if no errors
                    @if(!$errors->has('chief_complaint'))
                        document.getElementById('bookingForm').reset();
                    @endif
                        }

                function handleFormSubmit(event) {
                    const submitButton = document.getElementById('submitButton');
                    const submitText = document.getElementById('submitText');
                    const submitLoading = document.getElementById('submitLoading');

                    // Show loading state
                    submitButton.disabled = true;
                    submitText.classList.add('hidden');
                    submitLoading.classList.remove('hidden');

                    // Form will submit normally - if validation fails, page will reload with errors
                    // and modal will auto-open due to the DOMContentLoaded check above
                }

                // Close on Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        const modal = document.getElementById('bookingModal');
                        if (!modal.classList.contains('hidden')) {
                            closeBookingModal(e);
                        }
                    }
                });

                // Focus trap in modal
                document.addEventListener('keydown', function (e) {
                    const modal = document.getElementById('bookingModal');
                    if (modal.classList.contains('hidden')) return;

                    const modalContent = document.getElementById('modal-content');
                    const focusableElements = modalContent.querySelectorAll(
                        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                    );
                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];

                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstElement) {
                                e.preventDefault();
                                lastElement.focus();
                            }
                        } else {
                            if (document.activeElement === lastElement) {
                                e.preventDefault();
                                firstElement.focus();
                            }
                        }
                    }
                });
            </script>
        @endif
    @endauth
</x-guest-layout>