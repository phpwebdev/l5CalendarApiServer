<?php

namespace App;

use App\Category;
use App\Color;
use App\Status;
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
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'color_id', 'category_id', 'status_id'];

    public function color() {
        return $this->belongsTo('App\Color');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
