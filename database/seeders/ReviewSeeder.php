<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = \App\Models\User::where('role', 'doctor')->get();
        $patients = \App\Models\User::where('role', 'patient')->get();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            return;
        }

        foreach ($doctors as $doctor) {
            $numReviews = rand(3, 10);
            $selectedPatients = $patients->random(min($numReviews, $patients->count()));

            foreach ($selectedPatients as $patient) {
                \App\Models\Review::create([
                    'doctor_id' => $doctor->id,
                    'patient_id' => $patient->id,
                    'rating' => rand(3, 5),
                    'comment' => 'Great doctor, highly recommended!',
                ]);
            }
        }
    }
}
