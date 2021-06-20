<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodDistribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates =  [
        'deleted_at'
    ];

    protected $fillable = [
        'department',
        'paynumber',
        'name',
        'card_number',
        'issue_date',
        'allocation',
        'done_by',
        'status',
        'date_collected',
        'collected_by',
        'id_number',
    ];

    public function allocation(){
        return $this->belongsTo(Allocation::class,'paynumber','paynumber');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'paynumber','paynumber');
    }

}
