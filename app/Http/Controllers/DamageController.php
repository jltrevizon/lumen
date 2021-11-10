<?php

namespace App\Http\Controllers;

use App\Repositories\DamageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DamageController extends Controller
{

    public function __construct(DamageRepository $damageRepository)
    {
        $this->damageRepository = $damageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->damageRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->damageRepository->store($request), Response::HTTP_CREATED);
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
        return $this->updateDataResponse($this->damageRepository->update($request, $id), Response::HTTP_OK);
    }

}
