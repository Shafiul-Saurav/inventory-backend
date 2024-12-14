<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User as Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerList = collect([
            [
                'name' => 'Customer1',
                'phone' => '01810000001',
                'email' => 'customer1@inventory.com',
            ],
            [
                'name' => 'Customer2',
                'phone' => '01810000002',
                'email' => 'customer2@inventory.com',
            ],
            [
                'name' => 'Customer3',
                'phone' => '01810000003',
                'email' => 'customer3@inventory.com',
            ],
            [
                'name' => 'Customer4',
                'phone' => '01810000004',
                'email' => 'customer4@inventory.com',
            ],
            [
                'name' => 'Customer5',
                'phone' => '01810000005',
                'email' => 'customer5@inventory.com',
            ],
            [
                'name' => 'Customer6',
                'phone' => '01810000006',
                'email' => 'customer6@inventory.com',
            ],
            [
                'name' => 'Customer7',
                'phone' => '01810000007',
                'email' => 'customer7@inventory.com',
            ]

        ]);

        foreach ($customerList as $customer) {
            Customer::create([
                'role_id' => Customer::CUSTOMER,
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'email' => $customer['email'],
                'password' => Hash::make(1234)
            ]);
        }
    }
}
