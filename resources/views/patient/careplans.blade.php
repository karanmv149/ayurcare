<x-app-layout>

    <!-- PAGE HEADER -->
    <section class="mb-14">
        <h2 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
            My Care Plans
        </h2>
        <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
            View and follow your personalized Ayurvedic care plans.
        </p>
    </section>

    <!-- CARE PLANS LIST -->
    @forelse ($carePlans as $plan)
        <section class="bg-white border border-gray-200 rounded-2xl p-6 mb-8 motion-card animate-fade-up">

            <div class="flex flex-wrap items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $plan->title }}
                </h3>
                <span class="text-sm text-gray-500">
                    {{ $plan->duration_days }} days
                </span>
            </div>

            <div class="space-y-5 text-sm text-gray-700 leading-relaxed">

                <div>
                    <span class="font-medium text-gray-800">Daily Routine</span>
                    <p class="mt-1 text-gray-600">
                        {{ $plan->daily_routine ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="font-medium text-gray-800">Diet Guidelines</span>
                    <p class="mt-1 text-gray-600">
                        {{ $plan->diet_guidelines ?? '—' }}
                    </p>
                </div>

                <div>
                    <span class="font-medium text-gray-800">Lifestyle Advice</span>
                    <p class="mt-1 text-gray-600">
                        {{ $plan->lifestyle_advice ?? '—' }}
                    </p>
                </div>

            </div>

        </section>
    @empty
        <p class="text-sm text-gray-600">
            No care plans assigned yet.
        </p>
    @endforelse

</x-app-layout>
