<?php

namespace App\Http\Controllers;

use App\Repositories\AccessoryVehicleRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessoryVehicleController extends Controller
{

    public function __construct(AccessoryVehicleRepository $accessoryVehicleRepository)
    {
        $this->accessoryVehicleRepository = $accessoryVehicleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->accessoryVehicleRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createDataResponse($this->accessoryVehicleRepository->store($request), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->createDataResponse($this->accessoryVehicleRepository->delete($request), Response::HTTP_CREATED);
    }
}
