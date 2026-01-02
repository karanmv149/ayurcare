<x-app-layout>

    <!-- PAGE HEADER -->
    <section class="mb-14">
        <h2 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
            Consultation for {{ $patient->name }}
        </h2>
        <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
            Record consultation details and clinical observations.
        </p>
    </section>

    <!-- FORM CARD -->
    <section class="bg-white border border-gray-200 rounded-2xl p-8 motion-card animate-fade-up">

        <form method="POST"
              action="{{ route('doctor.consultation.store', $patient) }}"
              class="space-y-6">
            @csrf

            <!-- Chief Complaint -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Chief Complaint
                </label>
                <textarea
                    name="chief_complaint"
                    rows="3"
                    placeholder="Chief Complaint"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- Assessment -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Assessment
                </label>
                <textarea
                    name="assessment"
                    rows="3"
                    placeholder="Assessment"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- Recommendations -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Recommendations
                </label>
                <textarea
                    name="recommendation"
                    rows="3"
                    placeholder="Recommendations"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Additional Notes
                </label>
                <textarea
                    name="notes"
                    rows="3"
                    placeholder="Additional Notes"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- SUBMIT -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition"
                >
                    Save Consultation
                </button>
            </div>

        </form>

    </section>

</x-app-layout>
