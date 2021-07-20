<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{

    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function provinces(){
        return $this->hasMany(Province::class, 'region_id');
    }
}
