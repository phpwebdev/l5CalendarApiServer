<?php
use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $statusArray = array('Needs Action', 'In Progress', 'Completed', 'Cancelled');
        foreach ($statusArray as $v) {
            Status::create([
                'name' => $v,
            ]);
        }
    }
}
