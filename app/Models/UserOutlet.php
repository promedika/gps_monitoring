<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outlet;

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
        'outlet_id'
    ];

    public function outlet()
    {
    return $this->belongsTo('App\Models\Outlet', 'outlet_id');
    }
}
