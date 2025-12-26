<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all institution users
        $institutionUsers = User::where('accountType', 'institution')->get();

        foreach ($institutionUsers as $user) {
            // Check if school already exists by centre_number
            $school = School::where('centre_number', $user->centre_number)->first();

            if (!$school) {
                // Create new school
                $school = School::create([
                    'name' => $user->institution_name,
                    'centre_number' => $user->centre_number,
                    'district' => $user->district,
                    'subcounty' => $user->subcounty,
                    'parish' => $user->parish,
                    'village' => $user->village,
                    'admin_name' => $user->adminName,
                    'admin_email' => $user->adminEmail,
                    'admin_phone' => $user->adminPhone,
                ]);
            }

            // Update user with school_id
            $user->update(['school_id' => $school->id]);
        }
    }
}
