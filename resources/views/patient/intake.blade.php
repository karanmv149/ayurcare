<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Health Intake</h2>

    <form method="POST" action="{{ route('patient.intake.store') }}" class="space-y-4">
        @csrf

        <input name="age" placeholder="Age" class="w-full border p-2" />
        <input name="gender" placeholder="Gender" class="w-full border p-2" />

        <select name="diet_type" class="w-full border p-2">
            <option value="">Diet Type</option>
            <option value="light">Light</option>
            <option value="heavy">Heavy</option>
            <option value="spicy">Spicy</option>
        </select>

        <select name="sleep_quality" class="w-full border p-2">
            <option value="">Sleep Quality</option>
            <option value="light">Light</option>
            <option value="deep">Deep</option>
        </select>

        <select name="stress_level" class="w-full border p-2">
            <option value="">Stress Level</option>
            <option value="low">Low</option>
            <option value="high">High</option>
        </select>

        <select name="digestion" class="w-full border p-2">
            <option value="">Digestion</option>
            <option value="weak">Weak</option>
            <option value="strong">Strong</option>
        </select>

        <button class="bg-black text-white px-4 py-2 rounded">
            Save Profile
        </button>
    </form>

    @if(auth()->user()->patientProfile)
        <div class="mt-6 p-4 border rounded">
            <p><strong>Dominant Prakriti:</strong> {{ auth()->user()->patientProfile->dominant_prakriti }}</p>
        </div>
    @endif
</x-app-layout>
