<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_plan_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'start_date'
    ];

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function trainerAssignments()
    {
        return $this->hasMany(TrainerAssignment::class);
    }

    public function billingLogs()
    {
        return $this->hasMany(BillingLog::class);
    }
}