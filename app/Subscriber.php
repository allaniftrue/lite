<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * The fields that belong to the subscriber.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('value');
    }
}
