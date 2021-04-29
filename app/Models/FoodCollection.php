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
        'paynumber',
        'collected_by',
        'id_number',
        'name',
        'date_collected',
        'done_by',
    ];

    public function fdistribution() {
        return $this->belongsTo(FoodDistribution::class,'paynumber','paynumber');
    }

}
