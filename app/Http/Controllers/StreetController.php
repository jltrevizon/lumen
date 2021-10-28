<?php

namespace App\Http\Controllers;

use App\Repositories\StreetRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StreetController extends Controller
{

    public function __construct(StreetRepository $streetRepository)
    {
        $this->streetRepository = $streetRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->streetRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->streetRepository->store($request), Response::HTTP_CREATED);
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
        return $this->updateDataResponse($this->streetRepository->update($request, $id), Response::HTTP_OK);
    }

}