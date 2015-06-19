<?php

use App\Task;
use Carbon\Carbon;
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
        for ($x = 0; $x <= 150; $x++) {

            $repeatable = $faker->boolean();
            if ($repeatable) {
                $interval = $faker->randomElement(['day', 'week', 'month']);
            } else {
                $interval = '';
            }
            $start_at_1 = null;

            if ($repeatable === false) {

                $start_at = $faker
                    ->dateTimeBetween(
                        '-12 week',
                        '+14 week'
                    );

                $carbon     = new Carbon($start_at->format('Y-m-d H:i:s'));
                $start_at_1 = $carbon->endOfDay();

                $end_at = $faker
                    ->dateTimeBetween(
                        $start_at,
                        $start_at_1
                    );

            } else {
                $start_at_1 = $faker
                    ->dateTimeBetween(
                        '-12 week',
                        '+14 week'
                    );

                $end_at_1 = $faker
                    ->dateTimeBetween(
                        $start_at_1,
                        '+15 week'
                    );

                $end_at = $end_at_1;
                $carbon = new Carbon($end_at_1->format('Y-m-d H:i:s'));
                $end_at = $carbon->endOfDay();

                $start_at = $start_at_1;
                $carbon   = new Carbon($start_at_1->format('Y-m-d H:i:s'));
                $start_at = $carbon->startOfDay();
            }

            $task = Task::create([
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
            if ($repeatable === true) {
                $task = Task::generateRepeatableTask($start_at, $end_at, $interval, $task->id);
            }
        }
    }
}
