<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_year',
        'strand',
        'grade_level',
        'last_name',
        'first_name',
        'middle_name',
        'lrn',
        'place_of_birth',
        'birthdate',
        'sex',
        'age',
        'current_address',
        'permanent_address',
        'father_name',
        'mother_name',
        'guardian_name',
        'contact_number',
        'email',
        'psa_birth_certificate',
        'form137',
        'spa_major',
        'status',
        'rejection_reason',
        'rejected_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'rejected_at' => 'datetime',
        'birthdate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
