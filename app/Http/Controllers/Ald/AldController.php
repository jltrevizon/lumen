<?php

namespace App\Http\Controllers\Ald;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AldController extends Controller
{
    public function unapprovedTask(){
        try {
            $vehicles = Vehicle::with(['lastUnapprovedGroupTask','vehicleModel.brand','campa','category','lastQuestionnaire'])
            ->whereHas('lastUnapprovedGroupTask')
            ->whereHas('campa', function (Builder $builder) {
                return $builder->where('company_id', 1);
            })
            ->paginate(10);
            return response()->json(['vehicles' => $vehicles], 200);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

}
