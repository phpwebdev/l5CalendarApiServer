<?php

namespace App;

use App\Event;
use Illuminate\Database\Eloquent\Model;

class Status extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function event() {
        return $this->HasMany('App\Event');
    }
}
