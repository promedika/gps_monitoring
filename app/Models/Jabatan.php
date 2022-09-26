<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserOutlet;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
