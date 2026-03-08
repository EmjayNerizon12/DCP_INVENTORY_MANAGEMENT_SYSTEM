<?php

namespace Database\Seeders;

use App\Models\SchoolEquipment\SchoolEquipmentAllotmentClass;
use Illuminate\Database\Seeder;

class SchoolEquipmentAllotmentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed 10 allotment classes
        SchoolEquipmentAllotmentClass::factory()->count(10)->create();
    }
}
