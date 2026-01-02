<x-app-layout>

    <!-- PAGE HEADER -->
    <section class="mb-14">
        <h2 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
            Care Plan for {{ $patient->name }}
        </h2>
        <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
            Create a personalized Ayurvedic care plan for the patient.
        </p>
    </section>

    <!-- FORM CARD -->
    <section class="bg-white border border-gray-200 rounded-2xl p-8 motion-card animate-fade-up">

        <form method="POST"
              action="{{ route('doctor.careplan.store', $patient) }}"
              class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Plan Title
                </label>
                <input
                    name="title"
                    required
                    placeholder="Plan Title"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                />
            </div>

            <!-- Duration -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Duration (days)
                </label>
                <input
                    name="duration_days"
                    required
                    type="number"
                    placeholder="Duration (days)"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                />
            </div>

            <!-- Daily Routine -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Daily Routine
                </label>
                <textarea
                    name="daily_routine"
                    rows="3"
                    placeholder="Daily Routine"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- Diet Guidelines -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Diet Guidelines
                </label>
                <textarea
                    name="diet_guidelines"
                    rows="3"
                    placeholder="Diet Guidelines"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- Lifestyle Advice -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Lifestyle Advice
                </label>
                <textarea
                    name="lifestyle_advice"
                    rows="3"
                    placeholder="Lifestyle Advice"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                ></textarea>
            </div>

            <!-- SUBMIT -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition"
                >
                    Assign Care Plan
                </button>
            </div>

        </form>

    </section>

</x-app-layout>
