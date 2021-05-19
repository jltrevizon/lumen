<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeReservation;

class TypeReservationController extends Controller
{
    public function getAll(){
        return TypeReservation::all();
    }
}
