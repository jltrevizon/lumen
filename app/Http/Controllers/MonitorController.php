<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function index(Request $request){
        return Monitor::filter($request->all())->paginate($request->input('per_page'));
    }
}
