<?php

use App\Event;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create();
        for ($x = 0; $x <= 50; $x++) {
            $start_at = $faker
                ->dateTimeBetween(
                    $faker->dateTimeThisMonth('now'),
                    $faker->dateTimeThisMonth('now')
                );

            Event::create([
                'title'       => $faker->sentence(5),
                'category_id' => $faker->numberBetween(1, 10),
                'location'    => $faker->address(),
                'start_at'    => $start_at,
                'end_at'      => $faker
                    ->dateTimeBetween(
                        $start_at,
                        $faker->dateTimeThisMonth('now')
                    ),
            ]);
        }
    }
}
