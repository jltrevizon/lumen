<?php

namespace App\Http\Controllers\Invarat;

use App\Http\Controllers\Controller;
use App\Repositories\Invarat\InvaratWorkshopRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class InvaratWorkshopController extends Controller
{

    public function __construct(InvaratWorkshopRepository $invaratWorkshopRepository)
    {
        $this->invaratWorkshopRepository = $invaratWorkshopRepository;
    }

}
