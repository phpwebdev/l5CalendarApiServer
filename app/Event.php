<?php

namespace App;
use App\Category;
use App\Color;
use App\Status;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'repeatable',
        'interval',
        'location',
        'color_id',
        'category_id',
        'status_id',
        'parent_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'color_id', 'category_id', 'status_id'];

    public $data      = [];
    public $_color    = [];
    public $_category = null;
    public $_status   = null;

    public function color() {
        return $this->belongsTo('App\Color');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function search($search) {

        $query = DB::table('events');

        if (isset($search['search'])) {
            $query->where('title', 'LIKE', "%" . $search['search'] . "%");
        }

        $query->where('start_at', '>=', $search['dates']['start_at']);
        $query->where('end_at', '<=', $search['dates']['end_at']);

        if (isset($search['category'])) {
            $query->where('category_id', $search['category']);
        }
        $events_list = [];
        $events_list = $query->get();

        foreach ($events_list as $event) {
            $event->_color['name']    = Event::find($event->id)->color->name;
            $event->_color['hexCode'] = Event::find($event->id)->color->hex_code;
            $event->_category         = Event::find($event->id)->category->name;
            $event->_status           = Event::find($event->id)->status->name;

            if ($event->parent_id) {
                $this->data['repeatable'][] = $event;
            } else {
                $this->data['day'][] = $event;
            }
        }
        return $this->data;
    }

    public static function generateRepeatableEvent($start_at, $end_at, $interval, $parentId) {

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
            Event::addNewEvent($startAt, $endAt, $parentId);
        }

    }

    public static function addNewEvent($start_at, $end_at, $parentId) {
        $event = Event::find($parentId);

        Event::create([
            'title'       => $event->title,
            'description' => $event->description,
            'category_id' => $event->category_id,
            'location'    => $event->location,
            'start_at'    => $start_at,
            'end_at'      => $end_at,
            'repeatable'  => 0,
            'interval'    => null,
            'color_id'    => $event->color_id,
            'status_id'   => $event->status_id,
            'parent_id'   => $parentId,
        ]);
    }

}
