<x-guest-layout>

    <section class="max-w-7xl mx-auto px-4 pt-16 pb-10">
        <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-2 capitalize">
            {{ str_replace('-', ' ', $slug) }} Specialists
        </h1>
        <p class="text-gray-600 max-w-2xl">
            Explore verified doctors specializing in {{ str_replace('-', ' ', $slug) }}.
        </p>
    </section>

    <!-- DEMO DOCTOR GRID -->
    <section class="max-w-7xl mx-auto px-4 pb-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @for ($i = 1; $i <= 6; $i++)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 motion-card animate-fade-up">
                    <div class="h-16 w-16 rounded-full bg-gray-200 mb-4"></div>

                    <h3 class="font-semibold text-lg text-gray-900">
                        Dr. Demo {{ $i }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-3 capitalize">
                        {{ str_replace('-', ' ', $slug) }}
                    </p>

                    <span class="inline-block text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 mb-4">
                        Verified
                    </span>

                    <a href="/register" class="block text-sm font-medium text-gray-900 hover:underline">
                        Book Consultation →
                    </a>
                </div>
            @endfor
        </div>
    </section>

</x-guest-layout>
