<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $table = 'event_categories';

    public $timestamps = false;

    protected $fillable = ['event_id', 'category_id'];

    /**
     * Relationship to the Event model.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relationship to the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'id');
    }
}
