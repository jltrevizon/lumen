<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidence;
use App\Repositories\IncidenceRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class IncidenceController extends Controller
{

    public function __construct(IncidenceRepository $incidenceRepository)
    {
        $this->incidenceRepository = $incidenceRepository;
    }

    public function getAll(){
        return $this->getDataResponse($this->incidenceRepository->getAll(), HttpFoundationResponse::HTTP_OK);
    }

    public function getById($id){
        return $this->getDataResponse($this->incidenceRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){
        return $this->createDataResponse($this->incidenceRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function createIncidence(Request $request){
        return $this->createDataResponse($this->incidenceRepository->createIncidence($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function resolved($request){
        return $this->updateDataResponse($this->incidenceRepository->resolved($request), HttpFoundationResponse::HTTP_OK);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->incidenceRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        return $this->deleteDataResponse($this->incidenceRepository->delete($id), HttpFoundationResponse::HTTP_OK);
    }
}
