<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DCPPackageTypeSeeder extends Seeder
{
    /**
     * Seed DCP package types.
     */
    public function run(): void
    {
        $now = now();

        DB::table('dcp_package_types')->insertOrIgnore([
            ['code' => 'PKG-A', 'name' => 'Package A', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PKG-B', 'name' => 'Package B', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PKG-C', 'name' => 'Package C', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
