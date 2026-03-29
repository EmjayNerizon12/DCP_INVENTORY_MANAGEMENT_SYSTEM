<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DCPBatchSeeder extends Seeder
{
    /**
     * Seed DCP batches linked to schools and package types.
     */
    public function run(): void
    {
        $now = now();

        $packageTypeMap = DB::table('dcp_package_types')
            ->whereIn('code', ['PKG-A', 'PKG-B', 'PKG-C'])
            ->pluck('pk_dcp_package_types_id', 'code');

        $schools = DB::table('schools')
            ->whereIn('SchoolID', ['SCH-1001', 'SCH-1002', 'SCH-1003', 'SCH-1004', 'SCH-1005'])
            ->get(['pk_school_id', 'SchoolID', 'SchoolEmailAddress']);

        if ($schools->isEmpty() || $packageTypeMap->isEmpty()) {
            return;
        }

        $rows = [];
        foreach ($schools as $index => $school) {
            $packageCode = match ($index % 3) {
                0 => 'PKG-A',
                1 => 'PKG-B',
                default => 'PKG-C',
            };

            $rows[] = [
                'dcp_package_type_id' => $packageTypeMap[$packageCode] ?? null,
                'school_id' => $school->pk_school_id,
                'batch_label' => 'DCP-'.date('Y').'-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                'description' => 'Seeded batch for '.$school->SchoolID,
                'email' => $school->SchoolEmailAddress,
                'budget_year' => (int) date('Y'),
                'delivery_date' => date('Y-m-d'),
                'supplier_name' => 'Seed Supplier',
                'mode_of_delivery' => 'Direct Delivery',
                'submission_status' => 'FOR EDITING',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('dcp_batches')->insert($rows);
    }
}
