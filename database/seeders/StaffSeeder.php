<?php

namespace Database\Seeders;

use App\Models\User as Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffList = collect([
            [
                'name' => 'Stuff1',
                'phone' => '01610000001',
                'email' => 'stuff1@inventory.com',
                'nid' => '0161-000-000-1',
                'address' => 'Stuff1 Address',
            ],
            [
                'name' => 'Stuff2',
                'phone' => '01610000002',
                'email' => 'stuff2@inventory.com',
                'nid' => '0161-000-000-2',
                'address' => 'Stuff2 Address',
            ],
            [
                'name' => 'Stuff3',
                'phone' => '01610000003',
                'email' => 'stuff3@inventory.com',
                'nid' => '0161-000-000-3',
                'address' => 'Stuff3 Address',
            ],
            [
                'name' => 'Stuff4',
                'phone' => '01610000004',
                'email' => 'stuff4@inventory.com',
                'nid' => '0161-000-000-4',
                'address' => 'Stuff4 Address',
            ],
            [
                'name' => 'Stuff5',
                'phone' => '01610000005',
                'email' => 'stuff5@inventory.com',
                'nid' => '0161-000-000-5',
                'address' => 'Stuff5 Address',
            ],
            [
                'name' => 'Stuff6',
                'phone' => '01610000006',
                'email' => 'stuff6@inventory.com',
                'nid' => '0161-000-000-6',
                'address' => 'Stuff6 Address',
            ],
            [
                'name' => 'Stuff7',
                'phone' => '01610000007',
                'email' => 'stuff7@inventory.com',
                'nid' => '0161-000-000-7',
                'address' => 'Stuff7 Address',
            ]

        ]);

        foreach ($staffList as $staff) {
            Staff::create([
                'role_id' => Staff::STAFF,
                'name' => $staff['name'],
                'phone' => $staff['phone'],
                'email' => $staff['email'],
                'nid' => $staff['nid'],
                'password' => Hash::make(1234)
            ]);
        }
    }
}
