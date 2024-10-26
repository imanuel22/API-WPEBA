<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'name', 'topic'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
