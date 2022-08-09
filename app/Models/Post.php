<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'image',
        'outlet_name',
        'outlet_user',
        'user_id',
        'user_fullname',
        'imgTaken',
        'imgLoc',
    ];
}
