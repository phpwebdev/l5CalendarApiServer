<?php

namespace App;

use App\Category;
use App\Color;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    public $filter = [];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'start_at', 'end_at', 'repeatable', 'interval', 'location', 'parent_id', 'color_id', 'category_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public $data      = [];
    public $_color    = [];
    public $_category = null;

    public function color() {
        return $this->belongsTo('App\Color');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function search($search) {

        $query = DB::table('tasks');

        if (isset($search['search'])) {
            $query->where('title', 'LIKE', "%" . $search['search'] . "%");
        }

        $query->where('start_at', '>=', $search['dates']['start_at']);
        $query->where('end_at', '<=', $search['dates']['end_at']);

        if (isset($search['category'])) {
            $query->where('category_id', $search['category']);
        }

        $task_list = [];
        $task_list = $query->get();

        foreach ($task_list as $task) {

            $task->_color['name']    = Task::find($task->id)->color->name;
            $task->_color['hexCode'] = Task::find($task->id)->color->hex_code;
            $task->_category         = Task::find($task->id)->category->name;

            if ($task->parent_id) {
                $this->data['repeatable'][] = $task;
            } else {
                $this->data['day'][] = $task;
            }
        }
        return $this->data;
    }

    public static function generateRepeatableTask($start_at, $end_at, $interval, $parentId) {

        $newDate = new Carbon($start_at->format('Y-m-d H:i:s'));
        while ($newDate <= $end_at) {

            switch ($interval) {
                case 'day':
                    $newDate->addDay();
                    break;
                case 'week':
                    $newDate->addWeek();
                    break;
                case 'month':
                    $newDate->addMonth();
                    break;
            }
            $carbon  = new Carbon($newDate->format('Y-m-d H:i:s'));
            $startAt = $carbon->startOfDay();
            $carbon  = new Carbon($newDate->format('Y-m-d H:i:s'));
            $endAt   = $carbon->endOfDay();
            Task::addNewTask($startAt, $endAt, $parentId);
        }

    }

    public static function addNewTask($start_at, $end_at, $parentId) {
        $task = Task::find($parentId);

        Task::create([
            'title'       => $task->title,
            'description' => $task->description,
            'category_id' => $task->category_id,
            'location'    => $task->location,
            'start_at'    => $start_at,
            'end_at'      => $end_at,
            'repeatable'  => 0,
            'interval'    => null,
            'color_id'    => $task->color_id,
            'parent_id'   => $parentId,
        ]);
    }
}
