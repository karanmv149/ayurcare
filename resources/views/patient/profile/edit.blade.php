<x-app-layout>
    <section class="mb-8">
        <div class="mb-2">
            <h1 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
                Edit Patient Profile
            </h1>
            <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
                Update your personal information.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-gray-200 p-8 animate-fade-up">
        <form action="{{ route('patient.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                        Age
                    </label>
                    <input type="number" id="age" name="age" value="{{ old('age', $profile?->age) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           min="1" max="120">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                        Gender
                    </label>
                    <select id="gender" name="gender"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $profile?->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $profile?->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $profile?->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="primary_concern" class="block text-sm font-medium text-gray-700 mb-2">
                    Primary Concern
                </label>
                <textarea id="primary_concern" name="primary_concern" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Describe your main health concern...">{{ old('primary_concern', $profile?->primary_concern) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-black font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Profile
                </button>
            </div>
        </form>
    </section>
</x-app-layout>