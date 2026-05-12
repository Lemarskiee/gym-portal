<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'assigned_from',
        'assigned_to'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}