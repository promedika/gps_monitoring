<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mkt_sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'user_id',
        'sales_target',
        'sales_start',
        'sales_end'
    ];
}
