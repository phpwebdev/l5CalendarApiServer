<?php

use App\Category;
use App\Color;
use App\Event;
use App\Status;
use App\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET foreign_key_checks = 0');

        Category::truncate();
        Status::truncate();
        Color::truncate();
        Task::truncate();
        Event::truncate();

        Model::unguard();

        $this->call('CategorySeeder');
        $this->call('StatusSeeder');
        $this->call('ColorSeeder');

        $this->call('EventSeeder');
        $this->call('TaskSeeder');

        Model::reguard();
    }
}
