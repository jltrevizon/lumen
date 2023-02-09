<?php

namespace App\Http\Controllers;

use App\Models\EstimatedDate;
use Illuminate\Http\Request;

class EstimatedDateController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/estimated-dates",
     *     tags={"estimated-dates"},
     *     summary="Create estimated date",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     operationId="createEstimatedDate",
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EstimatedDate"),
     *     ),
     *     @OA\RequestBody(
     *         description="Create estimated date object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EstimatedDate"),
     *     )
     * )
     */

    public function store(Request $request) {
        $estimatedDate = EstimatedDate::create($request->all());
        return $estimatedDate;
    }

    /**
     * @OA\Put(
     *     path="/api/estimated-dates/{id}",
     *     tags={"estimated-dates"},
     *     summary="Updated estimated date",
     *     security={
     *          {"bearerAuth": {}}
     *     },
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
     *             type="integer"
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
