<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'start_datetime',
        'duration',
        'location',
        'contact',
        'maps',
        'user_id',
        'event_category_id',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan EventCategory
    // public function category()
    // {
    //     return $this->belongsTo(EventCategory::class, 'event_category_id');
    // }
    
}
