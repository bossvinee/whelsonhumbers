<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetDistribution extends Model
{
    use HasFactory;

    protected $dates =  [
        'deleted_at'
    ];

    protected $fillable = [
        'department',
        'paynumber',
        'name',
        'card_number',
        'issue_date',
        'month',
        'collected_by',
    ];
}
