<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Question model",
 *     description="Question model",
 * )
 */

class Question extends Model
{

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @OA\Property(
     *     property="company_id",
     *     type="integer",
     *     format="int64",
     *     description="Company ID",
     *     title="Company ID",
     * )
     *
     * @OA\Property(
     *     property="question",
     *     type="string",
     *     description="Question",
     *     title="Question",
     * )
     *
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
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
        'company_id',
        'question',
        'description'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function question_answer(){
        return $this->hasMany(QuestionAnswer::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByCompanyIds($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }

    public function scopeByNameQuestion($query, string $question){
        return $query->where('question', 'like', "%$question%");
    }

}
