<?php

use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sponsors')->insert([
        'cost' => '2.99',
        'duration' => '24',
      ]);
      DB::table('sponsors')->insert([
        'cost' => '5.99',
        'duration' => '72',
      ]);
      DB::table('sponsors')->insert([
        'cost' => '9.99',
        'duration' => '144',
      ]); 
    }
}
