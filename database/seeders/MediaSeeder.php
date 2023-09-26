<?php

namespace Database\Seeders;

use App\Models\Metadata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Metadata::create([
            'id' => 1,
            'basename' => 'Elchico(256x256).png',
            'filename' => '3002.jpg',
            'filepath' => 'backend/assets/images/users/3002.jpg',
            'type' => 'image/jpeg',
            'size' => '38001',
        ]);

    }
}
