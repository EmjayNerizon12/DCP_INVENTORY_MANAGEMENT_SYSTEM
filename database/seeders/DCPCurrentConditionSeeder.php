<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DCPCurrentConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            ['name' => 'Working'],
            ['name' => 'Not Working'],
            ['name' => 'For Repair'],
            ['name' => 'For Replacement'],
            ['name' => 'Missing'],
            ['name' => 'Damaged'],
            ['name' => 'Lost'],
            ['name' => 'Disposed'],
            ['name' => 'Under Maintenance'],
            ['name' => 'Transferred'],
        ];

        DB::table('dcp_current_conditions')->insert($conditions);
    }
}
