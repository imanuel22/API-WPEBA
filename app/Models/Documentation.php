<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    // Nama tabel, jika berbeda dari konvensi
    protected $table = 'documentations';

    // Field yang bisa diisi secara massal
    protected $fillable = [
        'image',
        'description',
        'event_id',
    ];

    // Relasi ke model Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
