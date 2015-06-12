<?php

namespace App;

use App\Event;
use App\Task;
use Illuminate\Database\Eloquent\Model;

class Color extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'hex_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function task() {
        return $this->HasMany('App\Task');
    }

    public function event() {
        return $this->HasMany('App\Event');
    }
}
