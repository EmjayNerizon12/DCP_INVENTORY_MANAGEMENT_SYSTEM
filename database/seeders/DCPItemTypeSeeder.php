<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DCPItemTypeSeeder extends Seeder
{
    /**
     * Seed DCP item types.
     */
    public function run(): void
    {
        $now = now();

        DB::table('dcp_item_types')->upsert(
            [
                ['code' => 'LAPTOP', 'name' => 'Laptop', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'DESKTOP', 'name' => 'Desktop', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PROJECTOR', 'name' => 'Projector', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PRINTER', 'name' => 'Printer', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'ROUTER', 'name' => 'Router', 'created_at' => $now, 'updated_at' => $now],
            ],
            ['code'],
            ['name', 'updated_at']
        );
    }
}
