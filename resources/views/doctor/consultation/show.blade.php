<x-app-layout>
    <!-- PAGE HEADER -->
    <section class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('doctor.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-semibold tracking-tight text-gray-900">
                Consultation Details
            </h1>
        </div>
        <p class="text-sm text-gray-600">
            Review patient request and provide your assessment.
        </p>
    </section>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- PATIENT INFO CARD -->
    <section class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-2xl font-semibold text-gray-400">
                    {{ strtoupper(substr($consultation->patient->name, 0, 1)) }}
                </span>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $consultation->patient->name }}</h2>
                <p class="text-sm text-gray-600">{{ $consultation->patient->email }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    Requested {{ $consultation->created_at->format('M d, Y \a\t g:i A') }}
                </p>
            </div>
            <div class="ml-auto">
                @if(empty($consultation->assessment) && empty($consultation->recommendation) && empty($consultation->notes))
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Completed
                    </span>
                @endif

                <!-- Video Call Button -->
                @if($consultation->video_status !== 'completed')
                    <a href="{{ route('consultations.video', $consultation->id) }}"
                        class="ml-4 inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-100 rounded-lg text-sm font-medium text-red-700 hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Start Video Call
                    </a>
                @endif

                <!-- Chat Button -->
                <a href="{{ route('messages.index', $consultation->id) }}"
                    class="ml-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Chat with Patient
                </a>
            </div>
        </div>
    </section>

    <!-- CONSULTATION FORM -->
    <section class="bg-white border border-gray-200 rounded-2xl p-8">

        <!-- Start Consultation Option -->
        @if(empty($consultation->assessment) && empty($consultation->recommendation) && empty($consultation->notes))
            @if(auth()->user()->doctorProfile && auth()->user()->doctorProfile->availability !== 'busy')
                <div class="mb-8 flex items-center justify-between p-4 bg-blue-50 border border-blue-100 rounded-xl">
                    <div>
                        <h3 class="font-medium text-blue-900">Ready to consult?</h3>
                        <p class="text-sm text-blue-700">Starting the consultation will automatically mark your status as
                            <strong>Busy</strong>.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('doctor.consultation.start', $consultation->id) }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Start Consultation
                        </button>
                    </form>
                </div>
            @endif
        @endif

        <form method="POST" action="{{ route('doctor.consultation.respond', $consultation->id) }}" class="space-y-6">
            @csrf

            <!-- Chief Complaint (Read-only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Patient's Chief Complaint
                </label>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">
                        {{ $consultation->chief_complaint ?? 'No details provided' }}
                    </p>
                </div>
            </div>

            <!-- Assessment -->
            <div>
                <label for="assessment" class="block text-sm font-medium text-gray-700 mb-2">
                    Assessment
                </label>
                <textarea id="assessment" name="assessment" rows="5" placeholder="Enter your clinical assessment..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none">{{ old('assessment', $consultation->assessment) }}</textarea>
                @error('assessment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recommendations -->
            <div>
                <label for="recommendation" class="block text-sm font-medium text-gray-700 mb-2">
                    Recommendations
                </label>
                <textarea id="recommendation" name="recommendation" rows="5" placeholder="Enter your recommendations..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none">{{ old('recommendation', $consultation->recommendation) }}</textarea>
                @error('recommendation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Notes
                </label>
                <textarea id="notes" name="notes" rows="4" placeholder="Any additional notes or observations..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none">{{ old('notes', $consultation->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- SUBMIT BUTTONS -->
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-colors">
                    Save Response
                </button>
                <a href="{{ route('doctor.dashboard') }}"
                    class="px-6 py-3 border border-gray-300 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </form>
    </section>

</x-app-layout>