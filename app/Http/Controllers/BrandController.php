<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAll(){
        return $this->brandRepository->getAll();
    }

    public function getById($id){
        return $this->brandRepository->getById($id);
    }
}
