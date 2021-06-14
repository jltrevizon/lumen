<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class Category extends Model
{

    protected $fillable = [
        'name',
        'description'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'category_id');
    }
}
