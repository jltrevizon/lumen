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

    /**
     * @OA\Put(
     *     path="/estimated-dates/{id}",
     *     tags={"estimated-dates"},
     *     summary="Updated estimated date",
     *     @OA\RequestBody(
     *         description="Updated estimated date object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EstimatedDate")
     *     ),
     *     operationId="updateEstimatedDate",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EstimatedDate"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estimated date not found"
     *     ),
     * )
     */

    public function update(Request $request, $id) {
        $estimatedDate = EstimatedDate::findOrFail($id);
        $estimatedDate->update($request->all());
        return $estimatedDate;
    }

}
