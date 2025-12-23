<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Patient Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="border p-4 rounded">
            <h2 class="font-semibold mb-2">Consultations</h2>
            <p class="text-sm mb-2">
                View your consultation history with doctors.
            </p>
            <a href="{{ route('patient.consultations') }}" class="underline text-sm">
                View Consultations
            </a>
        </div>

        <div class="border p-4 rounded">
            <h2 class="font-semibold mb-2">Care Plans</h2>
            <p class="text-sm mb-2">
                Track your assigned care plans and recommendations.
            </p>
            <a href="{{ route('patient.careplans') }}" class="underline text-sm">
                View Care Plans
            </a>
        </div>

    </div>
</x-app-layout>
