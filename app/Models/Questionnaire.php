<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Questionnaire model",
 *     description="Questionnaire model",
 * )
 */

class Questionnaire extends Model
{

    /**
     * @OA\Schema(
     *      schema="LastQuestionnaire",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Questionnaire"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="question_answers",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/QuestionAnswerWithQuestionAndTask")
     *              ),
     *          ),
     *      },
     * )
     * @OA\Schema(
     *      schema="QuestionnairePaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Questionnaire"),
     *              ),
     *          ),
     *      },
     * )
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @OA\Property(
     *     property="reception_id",
     *     type="integer",
     *     format="int64",
     *     description="Reception ID",
     *     title="Reception ID",
     * )
     *
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User ID",
     *     title="User ID",
     * )
     *
     * @OA\Property(
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
     * )
     *
     * @OA\Property(
     *     property="file",
     *     type="string",
     *     description="File",
     *     title="File",
     * )
     *
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time",
     *     description="When was created",
     *     title="Created at",
     * )
     *
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time",
     *     description="When was last updated",
     *     title="Updated at",
     * )
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'reception_id',
        'file'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }

    public function questionAnswers(){
        return $this->hasMany(QuestionAnswer::class);
    }

    public function groupTask(){
        return $this->hasOne(GroupTask::class);
    }
}
