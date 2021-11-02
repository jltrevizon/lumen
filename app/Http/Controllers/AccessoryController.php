<?php

namespace App\Http\Controllers;

use App\Repositories\AccessoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessoryController extends Controller
{

    public function __construct(AccessoryRepository $accessoryRepository)
    {
        $this->accessoryRepository = $accessoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->accessoryRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->accessoryRepository->store($request), Response::HTTP_CREATED);
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
        return $this->updateDataResponse($this->accessoryRepository->update($request, $id), Response::HTTP_OK);
    }

}
