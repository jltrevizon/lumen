<?php

namespace App\Http\Controllers;

use App\Models\EstimatedDate;
use Illuminate\Http\Request;

class EstimatedDateController extends Controller
{
    
    public function store(Request $request) {
        $estimatedDate = EstimatedDate::create($request->all());
        return $estimatedDate;
    }

    public function update(Request $request, $id) {
        $estimatedDate = EstimatedDate::findOrFail($id);
        $estimatedDate->update($request->all());
        return $estimatedDate;
    }

}
