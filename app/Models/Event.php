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

    // Relasi dengan Information
    public function information()
    {
        return $this->hasOne(Information::class);
    }

    // Relasi many-to-many ke Category
// Di model Event
public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_categories', 'event_id', 'category_id');
    }


    // Relasi one-to-many ke Feedback
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Relasi one-to-many ke Ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Relasi one-to-many ke Documentation
    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }
}
