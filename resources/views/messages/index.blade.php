<x-app-layout>
    <section class="mb-6">
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
            ← Back
        </a>
        <h1 class="text-3xl font-semibold text-gray-900">
            Chat with {{ auth()->user()->id === $booking->doctor_id ? 'Patient' : 'Doctor' }}
        </h1>
        <p class="text-sm text-gray-500">
            Booking #{{ $booking->id }} • {{ ucfirst($booking->status) }}
        </p>
    </section>

    <!-- Chat Container -->
    <div class="flex flex-col h-[600px] bg-white border border-gray-200 rounded-2xl overflow-hidden">

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50 flex flex-col-reverse">
            <!-- Note: flex-col-reverse keeps scroll at bottom usually, but we need to reverse order of messages if using that. 
                 Or we can just use JS to scroll to bottom. 
                 Let's stick to standard order and simple JS scroll. -->

            @if($messages->count() === 0)
                <div class="text-center py-10 text-gray-400">
                    No messages yet. Start the conversation!
                </div>
            @endif

            @foreach($messages as $message)
                @php
                    $isMe = $message->sender_id === auth()->id();
                @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div
                        class="max-w-[70%] {{ $isMe ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none' }} rounded-2xl px-5 py-3 shadow-sm">
                        <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                        <p class="text-[10px] mt-1 {{ $isMe ? 'text-blue-100' : 'text-gray-400' }}">
                            {{ $message->created_at->format('M d, g:i A') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-200">
            <form method="POST" action="{{ route('messages.store', $booking->id) }}" class="flex gap-4">
                @csrf
                <input type="text" name="message" required placeholder="Type your message..."
                    class="flex-1 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500" autofocus>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                    Send
                </button>
            </form>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom of chat
        const chatContainer = document.querySelector('.overflow-y-auto');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</x-app-layout>