<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- HEADER & STATUS -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Doctor Dashboard
                </h1>
                <p class="text-base text-gray-500">
                    Overview of your patients, queue, and today's schedule.
                </p>
            </div>

            @if($isVerified && auth()->user()->doctorProfile)
                <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-2xl shadow-sm border border-gray-100">
                    <!-- Status Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center gap-3 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            @php
                                $status = auth()->user()->doctorProfile->availability ?? 'offline';
                                $statusColors = [
                                    'available' => 'bg-green-500 shadow-green-200',
                                    'busy' => 'bg-red-500 shadow-red-200',
                                    'offline' => 'bg-gray-400 shadow-gray-200'
                                ];
                                $colorClass = $statusColors[$status] ?? 'bg-gray-400 shadow-gray-200';
                            @endphp
                            <span class="w-3 h-3 rounded-full {{ $colorClass }} shadow-lg ring-2 ring-white"></span>
                            <span class="text-sm font-semibold text-gray-700 capitalize">{{ ucfirst($status) }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.outside="open = false" 
                             class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl z-50 py-2 overflow-hidden transform origin-top-left transition-all">
                            @foreach(['available' => 'green', 'busy' => 'red', 'offline' => 'gray'] as $s => $c)
                                <form method="POST" action="{{ route('doctor.availability.update') }}">
                                    @csrf
                                    <input type="hidden" name="availability" value="{{ $s }}">
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center gap-3 transition-colors">
                                        <span class="w-2.5 h-2.5 rounded-full bg-{{ $c }}-500 ring-2 ring-{{ $c }}-100"></span>
                                        <span class="font-medium capitalize">{{ ucfirst($s) }}</span>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>

                    <div class="h-8 w-px bg-gray-200"></div>

                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Profile Status</span>
                         <span class="text-sm font-medium text-green-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Verified
                        </span>
                    </div>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(!$isVerified)
            <!-- NOT VERIFIED STATE -->
            <div class="bg-white border border-blue-100 rounded-2xl p-8 shadow-sm text-center max-w-2xl mx-auto mt-12">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Complete Your Profile</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    To start receiving patient consultations, please complete your professional profile verification.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('doctor.verify') }}" 
                       class="px-8 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all">
                        Start Verification
                    </a>
                </div>
                <p class="mt-6 text-sm text-gray-400">
                    Current Status: <span class="text-gray-600 font-medium">{{ auth()->user()->doctorProfile?->status ?? 'Draft' }}</span>
                </p>
            </div>
        
        @else
            <!-- MAIN DASHBOARD GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT COLUMN: QUEUE & ACTIONS (2/3) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Today's Queue Card -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Today's Live Queue</h2>
                                <p class="text-xs text-gray-500 mt-1">Patients currently waiting online</p>
                            </div>
                            
                            @if(isset($queue) && $queue->count() > 0)
                                <form method="POST" action="{{ route('doctor.queue.next') }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-500/30 flex items-center gap-2">
                                        <span>Next Patient</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if(isset($queue) && $queue->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-500">
                                        <tr>
                                            <th class="px-6 py-4">#</th>
                                            <th class="px-6 py-4">Patient</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4">Joined At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($queue as $item)
                                            <tr class="group hover:bg-blue-50/30 transition-colors {{ $item->status === 'in_progress' ? 'bg-blue-50' : '' }}">
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-600 shadow-sm group-hover:border-blue-200 group-hover:text-blue-600">
                                                        {{ $item->position }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="font-medium text-gray-900">{{ $item->patient->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ $item->patient->email }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($item->status === 'in_progress')
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                            In Session
                                                        </span>
                                                    @elseif($item->status === 'waiting')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                                            Waiting
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $item->created_at->format('h:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-medium mb-1">Queue is Empty</h3>
                                <p class="text-sm text-gray-500">There are no patients waiting in the queue right now.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: ALERTS & REQUESTS (1/3) -->
                <div class="space-y-8">
                    
                    <!-- Incoming Consultations -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden h-fit">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-900">Incoming Requests</h2>
                            @if(isset($pendingConsultations) && $pendingConsultations->count() > 0)
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm shadow-red-500/30">
                                    {{ $pendingConsultations->count() }} New
                                </span>
                            @endif
                        </div>

                        @if(isset($pendingConsultations) && $pendingConsultations->count() > 0)
                            <div class="divide-y divide-gray-100">
                                @foreach($pendingConsultations as $consultation)
                                    <div class="relative block p-5 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-start gap-4">
                                            <!-- Click target for details -->
                                            <a href="{{ route('doctor.consultation.show', $consultation->id) }}" class="absolute inset-0 z-0"></a>

                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold z-10 relative">
                                                {{ strtoupper(substr($consultation->patient->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-1 min-w-0 z-10 relative pointer-events-none">
                                                <p class="text-sm font-semibold text-gray-900 mb-0.5 group-hover:text-blue-600 transition-colors">
                                                    {{ $consultation->patient->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 mb-2 truncate">
                                                    {{ $consultation->symptoms ?? 'New Consultation Request' }}
                                                </p>
                                                <span class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                                    {{ $consultation->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="flex-shrink-0 z-10 relative flex items-center gap-2">
                                                @if($consultation->video_status !== 'completed')
                                                    <a href="{{ route('consultations.video', $consultation->id) }}" 
                                                       class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-colors" 
                                                       title="Start Video Call">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    </a>
                                                @endif
                                                <div class="text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">View All History</a>
                            </div>
                        @else
                            <div class="p-8 text-center bg-white">
                                <p class="text-sm text-gray-500">No new consultation requests.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20">
                        <h3 class="font-bold text-lg mb-4">Doctor Tools</h3>
                        <div class="space-y-3">
                            <a href="{{ route('doctor.profile.edit') }}" class="flex items-center gap-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors border border-white/10">
                                <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-sm font-medium">Edit Public Profile</span>
                            </a>
                            <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors border border-white/10 text-left">
                                <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                <span class="text-sm font-medium">Create Manual Booking</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>


</x-app-layout>
