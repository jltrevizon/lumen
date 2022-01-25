<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupTask;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Repositories\GroupTaskRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class GroupTaskController extends Controller
{

    public function __construct(GroupTaskRepository $groupTaskRepository)
    {
        $this->groupTaskRepository = $groupTaskRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->groupTaskRepository->getAll($request), HttpFoundationResponse::HTTP_OK);
    }

    public function getById(Request $request, $id){
        return $this->getDataResponse($this->groupTaskRepository->getById($request, $id),HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'vehicle_id' => 'required|integer'
        ]);

        return $this->createDataResponse($this->groupTaskRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->groupTaskRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        GroupTask::where('id', $id)
            ->delete();

        return [ 'message' => 'Group task deleted' ];
    }

    public function approvedGroupTaskToAvailable(Request $request){
        $data = $this->groupTaskRepository->approvedGroupTaskToAvailable($request);
        if (!is_null($data)) {
            return $this->updateDataResponse($data, HttpFoundationResponse::HTTP_OK);
        } else {
            return $this->updateDataResponse($data, HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function declineGroupTask(Request $request){
        return $this->updateDataResponse($this->groupTaskRepository->declineGroupTask($request), HttpFoundationResponse::HTTP_OK);
    }

}
