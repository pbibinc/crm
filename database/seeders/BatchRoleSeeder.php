<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'tl_sales'],
            ['id' => 2, 'name' => 'tl_csr_renewal'],
            ['id' => 3, 'name' => 'tl_csr_cancellation'],
            ['id' => 4, 'name' => 'tl_accountant'],
            ['id' => 6, 'name' => 'tl_quotation'],
            ['id' => 7, 'name' => 'Lead Generator'],
            ['id' => 8, 'name' => 'Quoter'],
            ['id' => 9, 'name' => 'application_taker'],
            ['id' => 10, 'name' => 'market_specialist'],
            ['id' => 11, 'name' => 'broker_assistant'],
            ['id' => 12, 'name' => 'Insured'],
            ['id' => 13, 'name' => 'executives'],
            ['id' => 14, 'name' => 'accountant'],
            ['id' => 15, 'name' => 'customer_service-cancellation'],
            ['id' => 16, 'name' => 'customer-service-renewal'],
            ['id' => 17, 'name' => 'customer-service-cert-request'],
            ['id' => 18, 'name' => 'lead_generator'],
            ['id' => 19, 'name' => 'customer-service-binding'],
            ['id' => 20, 'name' => 'marketing'],
        ];
        Role::insert($data);
    }
}
