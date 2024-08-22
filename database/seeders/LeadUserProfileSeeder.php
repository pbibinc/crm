<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadUserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lead = Lead::find(1);
        $userProfile = UserProfile::find(1);
        $lead->userProfile()->attach($userProfile, [
            'assigned_at' => now(),
            'current_user_id' => $userProfile->id
        ]);
        $lead->status = 10000;
        $lead->save();
    }
}