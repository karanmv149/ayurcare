<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Pending Doctor Verifications</h2>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    @forelse($doctors as $doctor)
        <div class="border p-4 mb-4 rounded">
            <p><strong>Name:</strong> {{ $doctor->user->name }}</p>
            <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
            <p><strong>Qualification:</strong> {{ $doctor->qualification }}</p>
            <p><strong>Reg No:</strong> {{ $doctor->registration_number }}</p>

            <a href="{{ asset('storage/'.$doctor->certificate_path) }}" target="_blank" class="text-blue-600 underline">
                View Certificate
            </a>

            <div class="mt-3 flex gap-3">
                <form method="POST" action="{{ route('admin.doctors.approve', $doctor) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.doctors.reject', $doctor) }}">
                    @csrf
                    <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
                </form>
            </div>
        </div>
    @empty
        <p>No pending doctors.</p>
    @endforelse
</x-app-layout>
