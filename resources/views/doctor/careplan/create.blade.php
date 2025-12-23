<x-app-layout>
    <h2 class="text-xl font-bold mb-4">
        Care Plan for {{ $patient->name }}
    </h2>

    <form method="POST" action="{{ route('doctor.careplan.store', $patient) }}" class="space-y-4">
        @csrf

        <input name="title" class="w-full border p-2" placeholder="Plan Title" required />
        <input name="duration_days" class="w-full border p-2" placeholder="Duration (days)" required />

        <textarea name="daily_routine" class="w-full border p-2" placeholder="Daily Routine"></textarea>
        <textarea name="diet_guidelines" class="w-full border p-2" placeholder="Diet Guidelines"></textarea>
        <textarea name="lifestyle_advice" class="w-full border p-2" placeholder="Lifestyle Advice"></textarea>

        <button class="bg-black text-white px-4 py-2 rounded">
            Assign Care Plan
        </button>
    </form>
</x-app-layout>
