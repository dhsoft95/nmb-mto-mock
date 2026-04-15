<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MtoAccount extends Model
{
    protected $table = 'mto_accounts';

    protected $fillable = [
        'client_id',
        'identifier',
        'identifier_type',
        'fsp_id',
        'destination_fsp',
        'full_name',
        'account_category',
        'account_type',
        'identity_type',
        'identity_value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
