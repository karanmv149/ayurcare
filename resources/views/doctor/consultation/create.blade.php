<x-app-layout>
    <h2 class="text-xl font-bold mb-4">
        Consultation for {{ $patient->name }}
    </h2>

    <form method="POST" action="{{ route('doctor.consultation.store', $patient) }}" class="space-y-4">
        @csrf

        <textarea name="chief_complaint" class="w-full border p-2" placeholder="Chief Complaint"></textarea>
        <textarea name="assessment" class="w-full border p-2" placeholder="Assessment"></textarea>
        <textarea name="recommendation" class="w-full border p-2" placeholder="Recommendations"></textarea>
        <textarea name="notes" class="w-full border p-2" placeholder="Additional Notes"></textarea>

        <button class="bg-black text-white px-4 py-2 rounded">
            Save Consultation
        </button>
    </form>
</x-app-layout>
