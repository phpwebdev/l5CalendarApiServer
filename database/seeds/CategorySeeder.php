<?php

use App\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($x = 0; $x <= 10; $x++) {
            $faker = Faker::create();
            Category::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
