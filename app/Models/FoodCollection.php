<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCollection extends Model
{
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'month',
        'card_number',
        'department',
        'paynumber',
        'collected_by',
        'id_number',
        'name',
        'date_collected',
        'done_by',
    ];
    
}
