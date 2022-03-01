<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{

    use HasFactory;

    protected $fillable = [
        'type_delivery_note_id',
        'body'
    ];

    protected $casts = [
        'body' => 'array'
    ];

    public function typeDeliveyNote(){
        return $this->belongsTo(TypeDeliveryNote::class);
    }
}
