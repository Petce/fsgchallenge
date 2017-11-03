<?php

use App\Player;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table
        Player::truncate();
        
        $faker = \Faker\Factory::create();
        
        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 100; $i++) {
            Player::create([
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'form' => $faker->randomFloat(2, 0, 1000),
                'total_points' => $faker->randomDigitNotNull,
                'influence' => $faker->randomFloat(2, 0, 1000),
                'creativity' => $faker->randomFloat(2, 0, 1000),
                'threat' => $faker->randomFloat(2, 0, 1000),
                'ict_index' => $faker->randomFloat(2, 0, 1000),
            ]);
        }
    }
}
