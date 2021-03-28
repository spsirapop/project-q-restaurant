<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_q',
        'phone',
        'id_q',
        'user_id'
    ];

    public function User(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
