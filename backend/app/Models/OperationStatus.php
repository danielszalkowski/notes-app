<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationStatus extends Model
{
    protected $casts = [
        'is_closed' => 'boolean',
    ];
}
