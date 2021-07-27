<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeReservation extends Model
{
    use HasFactory;

    const NORMAL = 1;
    const PRE_DELIVERY = 2;
}
