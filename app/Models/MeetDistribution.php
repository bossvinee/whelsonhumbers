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
        'allocation',
        'done_by',
        'status',
        'date_collected',
        'collected_by',
        'meet_a',
        'meet_b',
        'id_number',
    ];

    public function allocation(){
        return $this->belongsTo(Allocation::class,'paynumber','paynumber');
    }

}
