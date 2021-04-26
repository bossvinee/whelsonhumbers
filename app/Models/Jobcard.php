<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobcard extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'card_number',
        'date_opened',
        'card_month',
        'card_type',
        'quantity',
        'issued',
        'remaining',
        'extras_previous',
    ];
}
