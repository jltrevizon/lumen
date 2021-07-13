<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'category_id');
    }
}
