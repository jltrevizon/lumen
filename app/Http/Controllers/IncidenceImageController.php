<?php

namespace App\Http\Controllers;

use App\Repositories\IncidenceImageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidenceImageController extends Controller
{

    public function __construct(IncidenceImageRepository $incidenceImageRepository)
    {
        $this->incidenceImageRepository = $incidenceImageRepository;
    }
    /**
     * Display a listing of the resource.
     * @param \ilumiante\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return $this->getDataResponse($this->incidenceImageRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->incidenceImageRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->updateDataResponse($this->incidenceImageRepository->update($request, $id), Response::HTTP_OK);
    }

}
