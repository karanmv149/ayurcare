<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Platform oversight & approvals</p>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_users']) }}</p>
            </div>

            <!-- Total Doctors -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Doctors</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_doctors']) }}</p>
            </div>

            <!-- Verified Doctors -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Verified Doctors</p>
                <p class="text-3xl font-bold text-teal-600">{{ number_format($metrics['verified_doctors']) }}</p>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Pending Approvals</p>
                <p class="text-3xl font-bold text-amber-600">{{ number_format($metrics['pending_approvals']) }}</p>
            </div>

            <!-- Bookings Today -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Bookings Today</p>
                <p class="text-3xl font-bold text-indigo-600">{{ number_format($metrics['bookings_today']) }}</p>
            </div>

            <!-- Total Patients -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Patients</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_patients']) }}</p>
            </div>

            <!-- Total Consultations -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Consultations</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_consultations']) }}</p>
            </div>

            <!-- Total Reviews -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Reviews</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_reviews']) }}</p>
            </div>

            <!-- Total Care Plans (Optional/Secondary) -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Care Plans</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['total_care_plans']) }}</p>
            </div>
        </div>
    </div>
</x-app-layout>