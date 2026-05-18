<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainerRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'preferred_specialty',
        'message',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}