<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryVehiclesExport;
use App\Repositories\DeliveryVehicleRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class DeliveryVehicleController extends Controller
{

    public function __construct(DeliveryVehicleRepository $deliveryVehicleRepository)
    {
        $this->deliveryVehicleRepository = $deliveryVehicleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getDataResponse($this->deliveryVehicleRepository->index($request), Response::HTTP_OK);
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
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return $this->deleteDataResponse($this->deliveryVehicleRepository->delete($id), Response::HTTP_OK);
    }

    public function export(Request $request)
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '-1');
        $date = microtime(true);
        $array = explode('.', $date);
        ob_clean();
        return Excel::download(new DeliveryVehiclesExport($request->all()), 'Salidas-' . date('d-m-Y') . '-' . $array[0] . '.xlsx');
    }
}
