<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['filename'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_image');
    }
}
