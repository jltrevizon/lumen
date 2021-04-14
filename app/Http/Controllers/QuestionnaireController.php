<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Repositories\QuestionnaireRepository;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{

    public function __construct(QuestionnaireRepository $questionnaireRepository)
    {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function create($vehicle_id){
        return $this->questionnaireRepository->create($vehicle_id);
    }
}
