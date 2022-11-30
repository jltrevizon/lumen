<?php

namespace App\Http\Controllers;

use App\Repositories\SeverityDamageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeverityDamageController extends Controller
{

    public function __construct(SeverityDamageRepository $severityDamageRepository)
    {
        $this->severityDamageRepository = $severityDamageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getDataResponse($this->severityDamageRepository->index(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->severityDamageRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/severity-damages/{id}",
     *     tags={"severity-damages"},
     *     summary="Updated severity damage",
     *     @OA\RequestBody(
     *         description="Updated severity damage object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SeverityDamage")
     *     ),
     *     operationId="updateSeverityDamage",
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
     *         @OA\JsonContent(ref="#/components/schemas/SeverityDamage"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Severity damage not found"
     *     ),
     * )
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->updateDataResponse($this->severityDamageRepository->update($request, $id), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
