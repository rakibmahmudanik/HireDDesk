<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ১. একজন Employer ইউজার তৈরি করা
        $employer = User::factory()->create([
            'name' => 'Tech Corp Recruiter',
            'email' => 'employer@hireddesk.com',
            'role' => 'employer',
        ]);

        // ২. একটি কোম্পানি প্রোফাইল তৈরি করা
        $company1 = Company::create([
            'user_id' => $employer->id,
            'name' => 'ByteWave Technologies',
            'slug' => 'bytewave-technologies',
            'location' => 'Remote (Global)',
            'website' => 'https://example.com',
            'about' => 'Building modern cloud and web applications for global startups.',
        ]);

        $company2 = Company::create([
            'user_id' => $employer->id,
            'name' => 'Nova Studio',
            'slug' => 'nova-studio',
            'location' => 'Remote (US/EU)',
            'website' => 'https://novastudio.test',
            'about' => 'A boutique design and software agency.',
        ]);

        // ৩. কিছু ডামি জব পোস্টিং তৈরি করা
        JobListing::create([
            'company_id' => $company1->id,
            'title' => 'Senior Laravel & PHP Developer',
            'slug' => Str::slug('Senior Laravel PHP Developer ' . Str::random(5)),
            'description' => 'We are seeking an experienced Laravel engineer to lead our core API and web platform development.',
            'location' => 'Remote (Worldwide)',
            'type' => 'Full-time',
            'salary_min' => 60000,
            'salary_max' => 90000,
            'is_featured' => true,
            'status' => 'active',
        ]);

        JobListing::create([
            'company_id' => $company1->id,
            'title' => 'Full Stack Web Developer (Laravel + Vue)',
            'slug' => Str::slug('Full Stack Web Developer ' . Str::random(5)),
            'description' => 'Work across our backend Laravel services and modern reactive Blade/Vue frontends.',
            'location' => 'Remote (Worldwide)',
            'type' => 'Full-time',
            'salary_min' => 45000,
            'salary_max' => 65000,
            'is_featured' => false,
            'status' => 'active',
        ]);

        JobListing::create([
            'company_id' => $company2->id,
            'title' => 'UI/UX Designer & Frontend Specialist',
            'slug' => Str::slug('UI UX Designer ' . Str::random(5)),
            'description' => 'Create gorgeous, responsive user interfaces and turn them into Tailwind CSS templates.',
            'location' => 'Remote (US/EU)',
            'type' => 'Contract',
            'salary_min' => 40000,
            'salary_max' => 55000,
            'is_featured' => true,
            'status' => 'active',
        ]);
    }
}