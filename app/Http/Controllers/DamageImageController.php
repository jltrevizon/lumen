<?php

namespace App\Http\Controllers;

use App\Models\DamageImage;
use App\Repositories\DamageImageRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DamageImageController extends Controller
{

    public function __construct(DamageImageRepository $damageImageRepository)
    {
        $this->damageImageRepository = $damageImageRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->damageImageRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->damageImageRepository->store($request), Response::HTTP_CREATED);
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
        return $this->updateDataResponse($this->damageImageRepository->update($request, $id), Response::HTTP_OK);
    }

}
