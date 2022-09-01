<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAtt extends Model
{
    use HasFactory;

    protected $fillable = [
        'clock_in_img',
        'clock_in_time',
        'clock_in_loc',
        'clock_out_img',
        'clock_out_time',
        'clock_out_loc',
    ];
}
