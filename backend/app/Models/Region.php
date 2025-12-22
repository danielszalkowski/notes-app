<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'location_id'];

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function municipalities() {
        return $this->hasMany(Municipality::class);
    }
}