<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales_history extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sales_date',
        'tenant_id',
        'sales_value',
        'mkt_sales_id',
        'jml_alat',
        'jns_kerja',
        'keterangan',
        'status',
    ];
}
