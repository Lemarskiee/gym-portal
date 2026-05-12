<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'billing_month',
        'amount_due',
        'due_date',
        'status',
        'paid_at'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}