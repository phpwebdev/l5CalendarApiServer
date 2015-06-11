<?php
use App\Color;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder {
    public function run() {

        for ($i = 0; $x <= 10; $x++) {
            $faker = Faker::create();
            Color::create([
                'name'     => $faker->word(),
                'hex_code' => $faker->hexColor(),
            ]);
        }
    }
}
