<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'information';

    // Field yang bisa diisi secara massal
    protected $fillable = [
        'event_id',
        'whatapps',
        'telephone',
        'facebook',
        'instagram',
        'email',
        'website',
    ];

    // Relasi ke model Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
