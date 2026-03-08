<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolGradeLevelSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = now();

        DB::table('school_grade_levels')->upsert(
            [
                ['GradeLevelID' => 'K', 'GradeName' => 'Kinder', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '1', 'GradeName' => 'Grade I', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '2', 'GradeName' => 'Grade II', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '3', 'GradeName' => 'Grade III', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '4', 'GradeName' => 'Grade IV', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '5', 'GradeName' => 'Grade V', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => '6', 'GradeName' => 'Grade VI', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => 'JHS', 'GradeName' => 'Junior High School', 'created_at' => $now, 'updated_at' => $now],
                ['GradeLevelID' => 'SHS', 'GradeName' => 'Senior High School', 'created_at' => $now, 'updated_at' => $now],
            ],
            ['GradeLevelID'],
            ['GradeName', 'updated_at']
        );
    }
}
