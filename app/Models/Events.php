<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'location', 'date', 'time'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
