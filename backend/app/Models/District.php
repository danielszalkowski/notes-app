<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'municipality_id'];

    public function municipality() {
        return $this->belongsTo(Municipality::class);
    }

    public function neighborhoods() {
        return $this->hasMany(Neighborhood::class);
    }
}