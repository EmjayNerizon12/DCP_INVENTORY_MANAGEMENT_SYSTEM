<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolAndSchoolUserSeeder extends Seeder
{
    /**
     * Seed schools and their school users.
     */
    public function run(): void
    {
        $now = now();

        $schools = [
            [
                'SchoolID' => 'SCH-1001',
                'SchoolName' => 'Bagong Pag-asa Elementary School',
                'SchoolLevel' => 'Elementary School',
                'Region' => 'Region III',
                'Division' => 'Nueva Ecija',
                'District' => '1A',
                'Province' => 'Nueva Ecija',
                'CityMunicipality' => 'Cabanatuan City',
                'SchoolAddress' => 'Purok 1, Brgy. Bagong Pag-asa',
                'SchoolEmailAddress' => 'sch1001@deped.gov.ph',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'SchoolID' => 'SCH-1002',
                'SchoolName' => 'San Isidro Integrated School',
                'SchoolLevel' => 'Junior High School',
                'Region' => 'Region III',
                'Division' => 'Nueva Ecija',
                'District' => '5A',
                'Province' => 'Nueva Ecija',
                'CityMunicipality' => 'San Isidro',
                'SchoolAddress' => 'Brgy. Poblacion, San Isidro',
                'SchoolEmailAddress' => 'sch1002@deped.gov.ph',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'SchoolID' => 'SCH-1003',
                'SchoolName' => 'Mabini Senior High School',
                'SchoolLevel' => 'Senior High School',
                'Region' => 'Region III',
                'Division' => 'Nueva Ecija',
                'District' => '5B',
                'Province' => 'Nueva Ecija',
                'CityMunicipality' => 'Palayan City',
                'SchoolAddress' => 'Brgy. Atate, Palayan City',
                'SchoolEmailAddress' => 'sch1003@deped.gov.ph',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'SchoolID' => 'SCH-1004',
                'SchoolName' => 'Rizal Elementary School',
                'SchoolLevel' => 'Elementary School',
                'Region' => 'Region III',
                'Division' => 'Bulacan',
                'District' => '2A',
                'Province' => 'Bulacan',
                'CityMunicipality' => 'Malolos',
                'SchoolAddress' => 'Brgy. Sto. Nino, Malolos',
                'SchoolEmailAddress' => 'sch1004@deped.gov.ph',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'SchoolID' => 'SCH-1005',
                'SchoolName' => 'Quezon National High School',
                'SchoolLevel' => 'Junior High School',
                'Region' => 'Region IV-A',
                'Division' => 'Quezon',
                'District' => '5A',
                'Province' => 'Quezon',
                'CityMunicipality' => 'Lucena City',
                'SchoolAddress' => 'Brgy. Isabang, Lucena City',
                'SchoolEmailAddress' => 'sch1005@deped.gov.ph',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('schools')->upsert(
            $schools,
            ['SchoolID'],
            [
                'SchoolName',
                'SchoolLevel',
                'Region',
                'Division',
                'District',
                'Province',
                'CityMunicipality',
                'SchoolAddress',
                'SchoolEmailAddress',
                'updated_at',
            ]
        );

        $savedSchools = DB::table('schools')
            ->whereIn('SchoolID', array_column($schools, 'SchoolID'))
            ->get(['pk_school_id', 'SchoolID', 'SchoolEmailAddress']);

        foreach ($savedSchools as $school) {
            $defaultPassword = $school->SchoolID.'-123456';

            DB::table('school_users')->updateOrInsert(
                ['pk_school_id' => $school->pk_school_id],
                [
                    'username' => $school->SchoolEmailAddress,
                    'password' => Hash::make($defaultPassword),
                    'default_password' => $defaultPassword,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
