<x-app-layout>
    <section class="mb-8">
        <div class="mb-2">
            <h1 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
                Consultation Details
            </h1>
            <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
                View and manage consultation messages.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-gray-200 p-8 animate-fade-up">
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Consultation #{{ $consultation->id }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $consultation->created_at->format('M j, Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                        {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($consultation->status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Patient:</span>
                    <span class="text-gray-600 ml-2">{{ $consultation->patient->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Doctor:</span>
                    <span class="text-gray-600 ml-2">{{ $consultation->doctor->name }}</span>
                </div>
                @if($consultation->symptoms)
                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-700">Symptoms:</span>
                        <p class="text-gray-600 mt-1">{{ $consultation->symptoms }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Messages</h3>
            
            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                @foreach($consultation->messages()->orderBy('created_at')->get() as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="text-xs text-gray-500 mb-1">
                                {{ $message->sender->name }} • {{ $message->created_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="rounded-lg px-4 py-2 
                                {{ $message->sender_id === auth()->id() 
                                    ? 'bg-blue-600 text-white' 
                                    : 'bg-gray-100 text-gray-900' }}">
                                {{ $message->body }}
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($consultation->messages->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        No messages yet. Start the conversation below.
                    </div>
                @endif
            </div>

            <form action="{{ route('consultations.messages.store', $consultation) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="body" 
                       placeholder="Type your message..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Send
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
