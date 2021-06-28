<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReceptionRepository;

class ReceptionController extends Controller
{
    public function __construct(ReceptionRepository $receptionRepository)
    {
        $this->receptionRepository = $receptionRepository;
    }

    public function create(Request $request){
        return $this->receptionRepository->create($request);
    }

    public function getById($id){
        return $this->receptionRepository->getById($id);
    }
}
