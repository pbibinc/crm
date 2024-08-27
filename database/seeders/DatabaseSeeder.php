<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(LeadSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmenSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(UserProfileSeeder::class);
        $this->call(QuotationMarketSeeder::class);
        $this->call(WebsiteOriginatedSeeder::class);
        $this->call(InsurerSeeder::class);
        $this->call(FinanceCompanySeeder::class);
        $this->call(LeadUserProfileSeeder::class);
    }
}