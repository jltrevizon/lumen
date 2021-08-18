<?php

namespace App\Repositories;

use App\Models\Campa;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class CampaRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return Campa::with($this->getWiths($request->with))
                ->get();
    }

    public function getById($request, $id){
        return Campa::with($this->getWiths($request->with))
                ->findOrFail($id);
    }

    public function getCampasByCompany($companyId){
        return Campa::where('company_id', $companyId)
                    ->get();
    }

    public function getCampasByRegion($request){
        return Campa::with($this->getWiths($request->with))
                ->byRegion($request->input('region_id'))
                ->byCompany($request->input('company_id'))
                ->get();
    }

    public function getCampasByProvince($request){
        return Campa::with($this->getWiths($request->with))
                    ->byProvince($request->input('province_id'))
                    ->byCompany($request->input('company_id'))
                    ->get();
    }

    public function getByCompany($request){
        return Campa::with($this->getWiths($request->with))
                    ->byCompany($request->input('company_id'))
                    ->get();
    }

    public function create($request){
        $campa = Campa::create($request->all());
        return $campa;
    }

    public function update($request, $id){
        $campa = Campa::findOrFail($id);
        $campa->update($request->all());
        return ['campa' => $campa];
    }
}
