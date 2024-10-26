<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'session_name', 'start_time', 'end_time', 'description'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
