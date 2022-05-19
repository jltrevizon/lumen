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

    public function index(Request $request){
        return $this->getDataResponse($this->commentRepository->index($request), Response::HTTP_OK);
    }

    public function store(Request $request){
        return $this->createDataResponse($this->commentRepository->store($request), Response::HTTP_CREATED);
    }

}
