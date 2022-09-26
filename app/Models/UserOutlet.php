<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outlet;
use App\Models\Jabatan;

class UserOutlet extends Model
{
    use HasFactory;

    /**
     * write code on Method 
     * 
     * @return response()
     */
    protected $fillable = [
        'name',
        'outlet_id',
        'jabatan',
        'status'
    ];
}
