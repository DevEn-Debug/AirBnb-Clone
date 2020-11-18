<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('services')->insert([
            'service_name' => 'WiFi',
            'icon' => 'fas fa-wifi',
        ]);
        DB::table('services')->insert([
            'service_name' => 'Parking Spot',
            'icon' => 'fas fa-parking',
        ]);
        DB::table('services')->insert([
            'service_name' => 'Pool',
            'icon' => 'fas fa-swimmer',
        ]);
        DB::table('services')->insert([
            'service_name' => 'Reception',
            'icon' => 'fas fa-concierge-bell',
        ]);
        DB::table('services')->insert([
            'service_name' => 'Sauna',
            'icon' => 'fas fa-hot-tub',
        ]);
        DB::table('services')->insert([
            'service_name' => 'Sea View',
            'icon' => 'fas fa-water',
        ]);
    }
}
