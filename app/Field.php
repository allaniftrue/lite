<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * The subscribers that belong to the field.
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
