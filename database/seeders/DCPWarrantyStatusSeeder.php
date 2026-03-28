<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DCPWarrantyStatusSeeder extends Seeder
{
    public function run(): void
    {
        $ts = Carbon::parse('2025-07-09 20:21:54');

        DB::table('dcp_warranty_statuses')->updateOrInsert(
            ['pk_dcp_warranty_statuses_id' => 1],
            [
                'name' => 'Under Warranty',
                'created_at' => $ts,
                'updated_at' => $ts,
            ]
        );

        DB::table('dcp_warranty_statuses')->updateOrInsert(
            ['pk_dcp_warranty_statuses_id' => 2],
            [
                'name' => 'Out of Warranty',
                'created_at' => $ts,
                'updated_at' => $ts,
            ]
        );
    }
}
