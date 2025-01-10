<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tickets';

    // Field yang bisa diisi secara massal
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quantity',
        'payment_method',
            'payment_number',
            'payment_name',
        'image',
    ];

    // Relasi ke model Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
