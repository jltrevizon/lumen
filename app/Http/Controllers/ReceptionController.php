<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReceptionRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ReceptionController extends Controller
{
    public function __construct(ReceptionRepository $receptionRepository)
    {
        $this->receptionRepository = $receptionRepository;
    }

    public function index(Request $request)
    {
        return $this->getDataResponse($this->receptionRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);
        $data = $this->receptionRepository->create($request);
        if ($data) {
            return $this->createDataResponse($data, HttpFoundationResponse::HTTP_CREATED);
        }
        return $this->failResponse(['message' => 'El vehiculo ya tiene una recepcion use parametro ignore_reception en true para omitir y crear otra recepcion esta accion eliminara las tareas pendiente de esa recepcion'], HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    public function getById($id)
    {
        return $this->getDataResponse($this->receptionRepository->getById($id), HttpFoundationResponse::HTTP_OK);
    }

    public function updateReception(Request $request, $id)
    {
        return $this->updateDataResponse($this->receptionRepository->updateReception($request, $id), HttpFoundationResponse::HTTP_OK);
    }
}
