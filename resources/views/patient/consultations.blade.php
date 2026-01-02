<x-app-layout>

    <!-- PAGE HEADER -->
    <section class="mb-14">
        <h2 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
            Consultation History
        </h2>
        <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
            Review your past consultations and medical notes.
        </p>
    </section>

    <!-- CONSULTATION LIST -->
    @forelse ($consultations as $consultation)
        <section class="bg-white border border-gray-200 rounded-2xl p-6 mb-8 motion-card animate-fade-up">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">
                    <span class="font-medium text-gray-700">Date:</span>
                    {{ $consultation->created_at->format('d M Y') }}
                </p>

                <a href="{{ route('messages.index', $consultation->id) }}"
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg text-xs font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Chat
                </a>
            </div>

            <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                <div>
                    <span class="font-medium text-gray-800">Chief Complaint</span>
                    <p class="mt-1 text-gray-600">
                        {{ $consultation->chief_complaint ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="font-medium text-gray-800">Assessment</span>
                    <p class="mt-1 text-gray-600">
                        {{ $consultation->assessment ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="font-medium text-gray-800">Recommendations</span>
                    <p class="mt-1 text-gray-600">
                        {{ $consultation->recommendation ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="font-medium text-gray-800">Notes</span>
                    <p class="mt-1 text-gray-600">
                        {{ $consultation->notes ?? '—' }}
                    </p>
                </div>
            </div>
        </section>
    @empty
        <p class="text-sm text-gray-600">
            No consultations yet.
        </p>
    @endforelse

</x-app-layout>