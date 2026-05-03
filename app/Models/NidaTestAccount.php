<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NidaTestAccount extends Model
{
    use HasFactory;

    protected $table = 'nida_test_accounts';

    protected $fillable = [
        'nin',
        'full_name',
        'date_of_birth',
        'mother_name',
        'birth_place',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
