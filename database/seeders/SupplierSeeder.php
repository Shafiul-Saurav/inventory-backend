<?php

namespace Database\Seeders;

use App\Models\User as Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplierList = collect([
            [
                'name' => 'Company1',
                'phone' => '01710000001',
                'email' => 'company1@inventory.com',
                'nid' => '0171-000-000-1',
                'address' => 'Company1 Address',
                'company_name' => 'Company1',
            ],
            [
                'name' => 'Company2',
                'phone' => '01710000002',
                'email' => 'company2@inventory.com',
                'nid' => '0171-000-000-2',
                'address' => 'Company2 Address',
                'company_name' => 'Company2',
            ],
            [
                'name' => 'Company3',
                'phone' => '01710000003',
                'email' => 'company3@inventory.com',
                'nid' => '0171-000-000-3',
                'address' => 'Company3 Address',
                'company_name' => 'Company3',
            ],
            [
                'name' => 'Company4',
                'phone' => '01710000004',
                'email' => 'company4@inventory.com',
                'nid' => '0171-000-000-4',
                'address' => 'Company4 Address',
                'company_name' => 'Company4',
            ],
            [
                'name' => 'Company5',
                'phone' => '01710000005',
                'email' => 'company5@inventory.com',
                'nid' => '0171-000-000-5',
                'address' => 'Company5 Address',
                'company_name' => 'Company5',
            ],
            [
                'name' => 'Company6',
                'phone' => '01710000006',
                'email' => 'company6@inventory.com',
                'nid' => '0171-000-000-6',
                'address' => 'Company6 Address',
                'company_name' => 'Company6',
            ],
            [
                'name' => 'Company7',
                'phone' => '01710000007',
                'email' => 'company7@inventory.com',
                'nid' => '0171-000-000-7',
                'address' => 'Company7 Address',
                'company_name' => 'Company7',
            ]

        ]);

        foreach ($supplierList as $supplier) {
            Supplier::create([
                'role_id' => Supplier::SUPPLIER,
                'name' => $supplier['name'],
                'phone' => $supplier['phone'],
                'email' => $supplier['email'],
                'nid' => $supplier['nid'],
                'address' => $supplier['address'],
                'company_name' => $supplier['company_name'],
                'password' => Hash::make(1234)
            ]);
        }
    }
}
