<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Doctor Dashboard</h1>

    <div class="border rounded p-4 mb-4">
        <p class="mb-2">
            <strong>Status:</strong>
            {{ auth()->user()->doctorProfile?->status ?? 'Not submitted' }}
        </p>

        <a href="{{ route('doctor.verify') }}" class="underline text-sm">
            View / Update Verification
        </a>
    </div>

    <div class="border rounded p-4">
        <p class="text-gray-600">
            You can create consultations and care plans by opening a patient profile.
        </p>
    </div>
</x-app-layout>
