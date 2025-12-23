<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Consultation History</h2>

    @forelse ($consultations as $consultation)
        <div class="border rounded p-4 mb-4">
            <p><strong>Date:</strong> {{ $consultation->created_at->format('d M Y') }}</p>

            <p><strong>Chief Complaint:</strong><br>
                {{ $consultation->chief_complaint ?? '—' }}
            </p>

            <p><strong>Assessment:</strong><br>
                {{ $consultation->assessment ?? '—' }}
            </p>

            <p><strong>Recommendations:</strong><br>
                {{ $consultation->recommendation ?? '—' }}
            </p>

            <p><strong>Notes:</strong><br>
                {{ $consultation->notes ?? '—' }}
            </p>
        </div>
    @empty
        <p>No consultations yet.</p>
    @endforelse
</x-app-layout>
