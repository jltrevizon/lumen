<?php

namespace App\Http\Controllers;

use App\Repositories\TypeDeliveryNoteRepository;
use Illuminate\Http\Request;

class TypeDeliveryNoteController extends Controller
{
    public function __construct(TypeDeliveryNoteRepository $typeDeliveryNoteRepository)
    {
        $this->typeDeliveryNoteRepository = $typeDeliveryNoteRepository;
    }

    public function index(){
        return $this->getDataResponse($this->typeDeliveryNoteRepository->index());
    }
}
