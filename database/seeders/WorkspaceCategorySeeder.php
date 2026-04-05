<?php

namespace Database\Seeders;

use App\Models\WorkspaceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkspaceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology',
            'Sports',
            'Education',
            'Healthcare',
            'Finance',
            'Marketing',
            'Design',
            'Engineering',
            'Sales',
            'Human Resources',
            'Legal',
            'Media & Entertainment',
            'E-Commerce',
            'Gaming',
            'Real Estate',
            'Non-Profit',
            'Government',
            'Startups',
            'Food & Beverage',
            'Travel & Hospitality',
            'Fashion',
            'Music',
            'Arts & Culture',
            'Science & Research',
            'Automotive',
            'Construction',
            'Agriculture',
            'Retail',
            'Logistics & Supply Chain',
            'Cybersecurity',
        ];

        foreach ($categories as $category) {
            WorkspaceCategory::updateOrCreate(
                ['slug' => Str::slug($category)],
                ['title' => $category]
            );
        }
    }
}