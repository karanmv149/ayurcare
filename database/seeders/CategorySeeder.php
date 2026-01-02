<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Cardiology',
            'Dermatology',
            'Neurology',
            'Gastroenterology',
            'Pulmonology',
            'Oncology',
            'Ayurveda',
            'Skin Care',
            'Stress & Sleep',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
