<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campa;
use App\Repositories\CampaRepository;

class CampaController extends Controller
{

    public function __construct(CampaRepository $campaRepository)
    {
        $this->campaRepository = $campaRepository;
    }

    public function getAll(){
        return Campa::with(['province', 'company'])
                    ->get();
    }

    public function getById($id){
        return Campa::with(['province','company'])
                    ->where('id', $id)
                    ->first();
    }

    public function getCampasByRegion(Request $request){

        $this->validate($request, [
            'region_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        return $this->campaRepository->getCampasByRegion($request);
    }

    public function getCampasByProvince(Request $request){

        $this->validate($request, [
            'province_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        return $this->campaRepository->getCampasByProvince($request);
    }

    public function getByCompany(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer'
        ]);

        return Campa::with(['company'])
                    ->where('company_id', $request->input('company_id'))
                    ->get();
    }

    public function create(Request $request){

        $this->validate($request, [
            'company_id' => 'required|integer',
            'name' => 'required|string'
        ]);

        return $this->campaRepository->create($request);
    }

    public function update(Request $request, $id){
        return $this->campaRepository->update($request, $id);
    }

    public function delete($id){
        Campa::where('id', $id)
            ->delete();

        return [ 'message' => 'Campa deleted' ];
    }
}
