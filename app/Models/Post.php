<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceReport;

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
        'outlet_user_id',
        'outlet_name_id',
        'post_header_id',
        'jabatan_id',
        'jabatan_name',
        'activity',
    ];
}
