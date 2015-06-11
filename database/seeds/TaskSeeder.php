<?php

use App\Task;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder {
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
                    '-12 week',
                    '+14 week'
                );

            $end_at = $faker
                ->dateTimeBetween(
                    $start_at,
                    '+15 week'
                );

            $repeatable = $faker->boolean();
            if ($repeatable) {
                $interval = $faker->randomElement(['day', 'week', 'month']);
            } else {
                $interval = null;
            }

            Task::create([
                'title'       => $faker->sentence(5),
                'description' => $faker->paragraph(3),
                'category_id' => $faker->numberBetween(1, 10),
                'location'    => $faker->address(),
                'start_at'    => $start_at,
                'end_at'      => $end_at,
                'repeatable'  => $repeatable,
                'interval'    => $interval,
                'color_id'    => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
