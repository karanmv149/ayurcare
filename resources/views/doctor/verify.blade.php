<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Doctor Verification</h2>

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('doctor.verify.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input name="qualification" placeholder="Qualification" class="w-full border p-2" required />
        <input name="registration_number" placeholder="Registration Number" class="w-full border p-2" required />
        <input name="experience_years" placeholder="Experience (years)" class="w-full border p-2" />
        <input name="clinic_name" placeholder="Clinic Name" class="w-full border p-2" />

        <input type="file" name="certificate" required />

        <button class="bg-black text-white px-4 py-2 rounded">
            Submit for Verification
        </button>
    </form>

    @if($profile)
        <p class="mt-4 text-sm text-gray-600">
            Status: <strong>{{ ucfirst($profile->status) }}</strong>
        </p>
    @endif
</x-app-layout>
