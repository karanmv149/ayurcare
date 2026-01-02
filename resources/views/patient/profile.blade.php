<x-app-layout>
    <section class="mb-8">
        <div class="mb-2">
            <h1 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
                Patient Profile
            </h1>
            <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
                Manage your personal information and health details.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-gray-200 p-8 animate-fade-up">
        <form action="{{ route('patient.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                        Age
                    </label>
                    <input type="number" id="age" name="age" value="{{ old('age', $profile?->age) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           min="1" max="120">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                <div>
                    <label for="diet_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Diet Type
                    </label>
                    <select id="diet_type" name="diet_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Diet Type</option>
                        <option value="vegetarian" {{ old('diet_type', $profile?->diet_type) == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                        <option value="non-vegetarian" {{ old('diet_type', $profile?->diet_type) == 'non-vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
                        <option value="vegan" {{ old('diet_type', $profile?->diet_type) == 'vegan' ? 'selected' : '' }}>Vegan</option>
                        <option value="spicy" {{ old('diet_type', $profile?->diet_type) == 'spicy' ? 'selected' : '' }}>Spicy</option>
                        <option value="heavy" {{ old('diet_type', $profile?->diet_type) == 'heavy' ? 'selected' : '' }}>Heavy</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sleep_quality" class="block text-sm font-medium text-gray-700 mb-2">
                        Sleep Quality
                    </label>
                    <select id="sleep_quality" name="sleep_quality" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Sleep Quality</option>
                        <option value="deep" {{ old('sleep_quality', $profile?->sleep_quality) == 'deep' ? 'selected' : '' }}>Deep</option>
                        <option value="normal" {{ old('sleep_quality', $profile?->sleep_quality) == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="light" {{ old('sleep_quality', $profile?->sleep_quality) == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="poor" {{ old('sleep_quality', $profile?->sleep_quality) == 'poor' ? 'selected' : '' }}>Poor</option>
                    </select>
                </div>

                <div>
                    <label for="stress_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Stress Level
                    </label>
                    <select id="stress_level" name="stress_level" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Stress Level</option>
                        <option value="low" {{ old('stress_level', $profile?->stress_level) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="moderate" {{ old('stress_level', $profile?->stress_level) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="high" {{ old('stress_level', $profile?->stress_level) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="digestion" class="block text-sm font-medium text-gray-700 mb-2">
                    Digestion
                </label>
                <select id="digestion" name="digestion" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Digestion Type</option>
                    <option value="strong" {{ old('digestion', $profile?->digestion) == 'strong' ? 'selected' : '' }}>Strong</option>
                    <option value="normal" {{ old('digestion', $profile?->digestion) == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="weak" {{ old('digestion', $profile?->digestion) == 'weak' ? 'selected' : '' }}>Weak</option>
                </select>
            </div>

            @if($profile?->dominant_prakriti)
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <h3 class="text-sm font-medium text-blue-900 mb-1">Your Dominant Prakriti</h3>
                    <p class="text-blue-800 font-medium">{{ $profile->dominant_prakriti }}</p>
                </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Profile
                </button>
            </div>
        </form>
    </section>
</x-app-layout>
