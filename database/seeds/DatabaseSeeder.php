<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FestivalSeeder::class);
        $this->call(TypeRegistrationSeeder::class);
        $this->call(PromoCodeSeeder::class);
    }
}
