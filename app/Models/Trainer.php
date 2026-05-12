<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'specialty',
        'phone'
    ];

    public function assignments()
    {
        return $this->hasMany(TrainerAssignment::class);
    }
}