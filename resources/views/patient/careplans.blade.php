<x-app-layout>
    <h2 class="text-xl font-bold mb-4">My Care Plans</h2>

    @forelse ($carePlans as $plan)
        <div class="border rounded p-4 mb-4">
            <p><strong>Title:</strong> {{ $plan->title }}</p>
            <p><strong>Duration:</strong> {{ $plan->duration_days }} days</p>

            <p class="mt-2"><strong>Daily Routine:</strong><br>
                {{ $plan->daily_routine ?? '—' }}
            </p>

            <p class="mt-2"><strong>Diet Guidelines:</strong><br>
                {{ $plan->diet_guidelines ?? '—' }}
            </p>

            <p class="mt-2"><strong>Lifestyle Advice:</strong><br>
                {{ $plan->lifestyle_advice ?? '—' }}
            </p>
        </div>
    @empty
        <p>No care plans assigned yet.</p>
    @endforelse
</x-app-layout>
