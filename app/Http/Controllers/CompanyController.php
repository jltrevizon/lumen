<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CompanyController extends Controller
{

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
    * @OA\Get(
    *     path="/api/companies/getall",
    *     tags={"companies"},
    *     summary="Get all companies",
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Company"),
    *    ),
    *     @OA\Response(
    *         response="500",
    *         description="An error has occurred."
    *     )
    * )
    */
    public function index(Request $request){
        return $this->getDataResponse($this->companyRepository->index($request), HttpFoundationResponse::HTTP_OK);
    }

    public function show($id){
        return $this->getDataResponse($this->companyRepository->show($id), HttpFoundationResponse::HTTP_OK);
    }

    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->createDataResponse($this->companyRepository->create($request), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/companies/update/{id}",
     *     tags={"companies"},
     *     summary="Updated company",
     *     @OA\RequestBody(
     *         description="Updated company object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     operationId="updateCompany",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
     *     ),
     * )
     */

    public function update(Request $request, $id){
        return $this->updateDataResponse($this->companyRepository->update($request, $id), HttpFoundationResponse::HTTP_OK);
    }

    public function delete($id){
        Company::where('id', $id)
            ->delete();

        return [ 'message' => 'Company deleted' ];
    }
}
