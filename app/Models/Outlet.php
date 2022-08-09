<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserOutlet;

class Outlet extends Model
{
    use HasFactory;

    /**
     * write code on Method
     * 
     * @return response()
     */
    protected $fillable = [
        'name'
    ];

    public function useroutlet()
    {
        return $this->hasMany(UserOutlet::class, 'foreign_key','local_key');
    }
}
