<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl p-8
                    shadow-xl shadow-gray-200/40 border border-gray-100">

            <h1 class="text-2xl font-semibold text-gray-900 mb-1 text-center">
                Choose Your Role
            </h1>
            <p class="text-sm text-gray-600 mb-6 text-center">
                Select how you want to use AyurCare
            </p>

            <form method="POST" action="{{ route('auth.select-role') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="user_id" value="{{ session('user_id') }}">

                <div class="space-y-3">
                    <button type="submit" name="role" value="patient"
                            class="w-full flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <span class="ml-2">Continue as Patient</span>
                    </button>

                    <button type="submit" name="role" value="doctor"
                            class="w-full flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <span class="ml-2">Continue as Doctor</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>