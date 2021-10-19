<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll(Request $request){
        return $this->getDataResponse($this->commentRepository->getAll($request), Response::HTTP_OK);
    }

    public function create(Request $request){
        return $this->createDataResponse($this->commentRepository->create($request), Response::HTTP_CREATED);
    }

}
