<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'region_id'];

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function districts() {
        return $this->hasMany(District::class);
    }
}