<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDeliveryNote extends Model
{

    use HasFactory;

    const DELIVERY = 1;
    const EXIT = 2;
    
    protected $fillable = [
        'description'
    ];

    protected $casts = [
        'description' => 'string'
    ];

    public function deliveryNotes(){
        return $this->hasMany(DeliveryNote::class);
    }

}
