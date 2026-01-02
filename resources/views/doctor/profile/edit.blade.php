<x-app-layout>
    <section class="mb-8">
        <div class="mb-2">
            <h1 class="animate-fade-up text-3xl font-semibold tracking-tight text-gray-900 mb-2">
                Edit Doctor Profile
            </h1>
            <p class="animate-fade-up text-sm text-gray-600" data-delay="1">
                Update your professional information.
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
        <form action="{{ route('doctor.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Bio
                </label>
                <textarea id="bio" name="bio" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tell patients about yourself...">{{ old('bio', $profile?->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Specialty
                    </label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Select Specialty</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $profile?->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">
                        Experience (Years)
                    </label>
                    <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $profile?->experience_years) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           min="0" max="50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="consultation_fee" class="block text-sm font-medium text-gray-700 mb-2">
                        Consultation Fee (₹)
                    </label>
                    <input type="number" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $profile?->consultation_fee) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           min="0">
                </div>

                <div>
                    <label for="clinic_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Clinic Name
                    </label>
                    <input type="text" id="clinic_name" name="clinic_name" value="{{ old('clinic_name', $profile?->clinic_name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
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