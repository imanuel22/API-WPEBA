<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi
    protected $table = 'registrations';

    // Field yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'ticket_id',
        'registration_date',
        'status',
        'total_price',
        'image_payment',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
