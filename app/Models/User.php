<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoleAndPermission, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'paynumber',
        'first_name',
        'last_name',
        'mobile',
        'department',
        'usertype',
        'email',
        'password',
        'activated',
        'fcount',
        'mcount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function allocation(){
        return $this->hasOne(Allocation::class,'paynumber','paynumber');
    }

    public function department() {
        return $this->hasOne(Department::class,'department','department');
    }

    public function usertype() {
        return $this->hasOne(Usertype::class,'type','usertype');
    }

}
