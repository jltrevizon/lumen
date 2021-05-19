<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradeState;

class TradeStateController extends Controller
{
    public function getAll(){
        return TradeState::all();
    }
}
