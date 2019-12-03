<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['name', 'email', 'status'];

    /**
     * The fields that belong to the subscriber.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('id','value');
    }
}
