<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allocation extends Model
{
    use HasFactory, SoftDeletes;

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

    public function fdistribution(){
        return $this->hasOne(FoodDistribution::class,'paynumber','paynumber');
    }

    public function mdistribution(){
        return $this->hasOne(MeetDistribution::class,'paynumber','paynumber');
    }

}
