<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_name',
        'doctor_specialist',
        'doctor_phone',
        'doctor_email',
        'sip',
        'address',
        'photo',
        'id_ihs',
        'nik'
    ];
}
