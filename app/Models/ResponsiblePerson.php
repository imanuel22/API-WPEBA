<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsiblePerson extends Model
{
    use HasFactory;

    protected $table = 'responsible_people';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telp',
        'foto_ktp',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
