<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    public function status()
    {
        return $this->belongsTo(OperationStatus::class, 'operation_status_id');
    }
}
