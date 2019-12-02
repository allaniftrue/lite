<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Field extends Model
{
    protected $appends = ['uuid'];

    /**
     * The subscribers that belong to the field.
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }

    public function getUUIDAttribute()
    {
        return (string) Str::uuid();
    }
}
