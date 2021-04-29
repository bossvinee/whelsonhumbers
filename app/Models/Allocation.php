<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'paynumber',
        'food_allocation',
        'meet_allocation',
        'meet_a',
        'meet_b',
        'allocation',
        'status'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function user(){
        return $this->belongsTo(User::class,'paynumber','paynumber');
    }

}
