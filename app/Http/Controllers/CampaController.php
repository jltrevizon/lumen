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
        return $this->campaRepository->getCampasByRegion($request);
    }

    public function getByCompany(Request $request){
        return Campa::with(['company'])
                    ->where('company_id', $request->json()->get('company_id'))
                    ->get();
    }

    public function create(Request $request){
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
