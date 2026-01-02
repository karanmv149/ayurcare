<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8" x-data="videoConsultation()">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Consultation with
                    {{ Auth::user()->id === $consultation->doctor_id ? $consultation->patient->name : 'Dr. ' . $consultation->doctor->name }}
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="status === 'connected' ? 'bg-green-100 text-green-800' : (status === 'ended' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')">
                        <span x-text="statusLabel"></span>
                    </span>
                    <span class="text-sm text-gray-500" x-show="timer" x-text="timer"></span>
                </div>
            </div>
            <button @click="endCall"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium transition-colors">
                End Consultation
            </button>
        </div>

        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[600px]">
            <!-- Local Video -->
            <div class="relative bg-black rounded-2xl overflow-hidden shadow-lg border border-gray-800 group">
                <video id="localVideo" autoplay playsinline muted
                    class="w-full h-full object-cover transform -scale-x-100"></video>
                <div
                    class="absolute bottom-4 left-4 bg-black/50 px-3 py-1 rounded-lg text-white text-sm backdrop-blur-sm">
                    You
                </div>
                <div class="absolute bottom-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="toggleAudio"
                        class="p-2 rounded-full bg-gray-800/80 text-white hover:bg-gray-700 overflow-hidden"
                        :class="{'bg-red-500 hover:bg-red-600': !audioEnabled}">
                        <svg x-show="audioEnabled" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                        <svg x-show="!audioEnabled" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
                                clip-rule="evenodd"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                        </svg>
                    </button>
                    <button @click="toggleVideo" class="p-2 rounded-full bg-gray-800/80 text-white hover:bg-gray-700"
                        :class="{'bg-red-500 hover:bg-red-600': !videoEnabled}">
                        <svg x-show="videoEnabled" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <svg x-show="!videoEnabled" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remote Video -->
            <div
                class="relative bg-gray-900 rounded-2xl overflow-hidden shadow-lg border border-gray-800 flex items-center justify-center">
                <video id="remoteVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                <div x-show="status !== 'connected'"
                    class="absolute inset-0 flex flex-col items-center justify-center bg-black/80 text-white">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mb-4"></div>
                    <p class="text-lg font-medium" x-text="statusLabel"></p>
                </div>
                <div
                    class="absolute bottom-4 left-4 bg-black/50 px-3 py-1 rounded-lg text-white text-sm backdrop-blur-sm">
                    {{ Auth::user()->id === $consultation->doctor_id ? $consultation->patient->name : 'Dr. ' . $consultation->doctor->name }}
                </div>
            </div>
        </div>

        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-4 items-start">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-medium text-blue-900">Consultation Notes</h4>
                <p class="text-sm text-blue-800 mt-1">
                    {{ $consultation->notes ?? 'No notes added yet.' }}
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('videoConsultation', () => ({
                status: 'initializing', // initializing, waiting, connecting, connected, ended
                audioEnabled: true,
                videoEnabled: true,
                timer: '00:00',
                startTime: null,
                timerInterval: null,

                peerConnection: null,
                localStream: null,
                remoteStream: null,
                signalInterval: null,
                lastMessageId: 0,

                isInitiator: {{ Auth::user()->id === $consultation->doctor_id ? 'true' : 'false' }},
                consultationId: {{ $consultation->id }},

                async init() {
                    console.log('Initializing Video Consultation');
                    this.status = 'initializing';
                    try {
                        await this.startLocalStream();

                        // Initialize PeerConnection
                        const configuration = {
                            iceServers: [
                                { urls: 'stun:stun.l.google.com:19302' },
                                { urls: 'stun:stun1.l.google.com:19302' }
                            ]
                        };
                        this.peerConnection = new RTCPeerConnection(configuration);

                        // Add tracks
                        this.localStream.getTracks().forEach(track => {
                            this.peerConnection.addTrack(track, this.localStream);
                        });

                        // Handle ICE candidates
                        this.peerConnection.onicecandidate = event => {
                            if (event.candidate) {
                                this.sendSignal('candidate', event.candidate);
                            }
                        };

                        // Handle remote stream
                        this.peerConnection.ontrack = event => {
                            console.log('Remote track received');
                            const remoteVideo = document.getElementById('remoteVideo');
                            if (remoteVideo.srcObject !== event.streams[0]) {
                                remoteVideo.srcObject = event.streams[0];
                                this.remoteStream = event.streams[0];
                                this.status = 'connected';
                                this.startTimer();
                            }
                        };

                        // Handle connection state
                        this.peerConnection.onconnectionstatechange = () => {
                            console.log('Connection state:', this.peerConnection.connectionState);
                            if (this.peerConnection.connectionState === 'connected') {
                                this.status = 'connected';
                            } else if (this.peerConnection.connectionState === 'disconnected') {
                                this.status = 'waiting';
                            }
                        };

                        // Signaling Polling
                        this.status = 'waiting';
                        this.signalInterval = setInterval(() => this.checkSignals(), 2000);

                        // If doctor, send offer
                        if (this.isInitiator) {
                            console.log('Creating offer...');
                            const offer = await this.peerConnection.createOffer();
                            await this.peerConnection.setLocalDescription(offer);
                            await this.sendSignal('offer', offer);

                            // Mark as started
                            await fetch(`{{ route('consultations.video.start', $consultation) }}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            });
                        }

                    } catch (e) {
                        console.error('Error starting video:', e);
                        alert('Could not access camera/microphone. Please check permissions.');
                        this.endCall();
                    }
                },

                async startLocalStream() {
                    this.localStream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    });
                    document.getElementById('localVideo').srcObject = this.localStream;
                },

                async sendSignal(type, payload) {
                    await fetch(`{{ route('consultations.video.signal', $consultation) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ type, payload })
                    });
                },

                async checkSignals() {
                    try {
                        const response = await fetch(`{{ route('consultations.video.signals', $consultation) }}?after_id=${this.lastMessageId}`);
                        const messages = await response.json();

                        for (const msg of messages) {
                            this.lastMessageId = Math.max(this.lastMessageId, msg.id);
                            const payload = JSON.parse(msg.payload);

                            if (msg.type === 'offer') {
                                if (!this.isInitiator) {
                                    console.log('Received offer');
                                    await this.peerConnection.setRemoteDescription(new RTCSessionDescription(payload));
                                    const answer = await this.peerConnection.createAnswer();
                                    await this.peerConnection.setLocalDescription(answer);
                                    await this.sendSignal('answer', answer);
                                }
                            } else if (msg.type === 'answer') {
                                if (this.isInitiator) {
                                    console.log('Received answer');
                                    await this.peerConnection.setRemoteDescription(new RTCSessionDescription(payload));
                                }
                            } else if (msg.type === 'candidate') {
                                console.log('Received candidate');
                                try {
                                    await this.peerConnection.addIceCandidate(new RTCIceCandidate(payload));
                                } catch (e) {
                                    console.error('Error adding received ice candidate', e);
                                }
                            }
                        }
                    } catch (e) {
                        console.error('Error checking signals:', e);
                    }
                },

                toggleAudio() {
                    this.audioEnabled = !this.audioEnabled;
                    this.localStream.getAudioTracks().forEach(track => track.enabled = this.audioEnabled);
                },

                toggleVideo() {
                    this.videoEnabled = !this.videoEnabled;
                    this.localStream.getVideoTracks().forEach(track => track.enabled = this.videoEnabled);
                },

                startTimer() {
                    if (this.timerInterval) return;
                    this.startTime = Date.now();
                    this.timerInterval = setInterval(() => {
                        const diff = Date.now() - this.startTime;
                        const minutes = Math.floor(diff / 60000);
                        const seconds = Math.floor((diff % 60000) / 1000);
                        this.timer = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }, 1000);
                },

                async endCall() {
                    clearInterval(this.signalInterval);
                    clearInterval(this.timerInterval);

                    if (this.peerConnection) this.peerConnection.close();
                    if (this.localStream) {
                        this.localStream.getTracks().forEach(track => track.stop());
                    }

                    this.status = 'ended';
                    await fetch(`{{ route('consultations.video.end', $consultation) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    window.location.href = "{{ route('home') }}";
                },

                get statusLabel() {
                    switch (this.status) {
                        case 'initializing': return 'Setting up devices...';
                        case 'waiting': return 'Waiting for ' + (this.isInitiator ? 'patient' : 'doctor') + '...';
                        case 'connected': return 'Consultation Live';
                        case 'ended': return 'Consultation Ended';
                        default: return 'Connecting...';
                    }
                }
            }));
        });
    </script>
</x-app-layout>