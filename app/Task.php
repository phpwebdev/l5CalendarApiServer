<?php

namespace App;

use App\Category;
use App\Color;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
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
    protected $fillable = ['title', 'description', 'start_at', 'end_at', 'repeatable', 'interval', 'location'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'color_id', 'category_id'];

    public function color() {
        return $this->belongsTo('App\Color');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
