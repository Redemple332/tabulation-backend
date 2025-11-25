<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Score extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'judge_id',
        'category_id',
        'candidate_id',
        'score',
        'description'
    ];


    public function scopeFilter($query)
    {
        $search = request('search') ?? false;
        $category_ids = request('category_ids') ?? false;
        $judge_id = request('judge_id') ?? false;
        $candidate_id = request('candidate_id') ?? false;
        $category_id = request('category_id') ?? false;

        $query->when(
            request('search')  ?? false,
            function ($query) use ($search) {
                $search = '%' . $search . '%';
                $query->when($search, function ($query) use ($search) {
                    $search = '%' . $search . '%';
                    $fillableFields = $this->fillable;
                    $query->where(function ($query) use ($fillableFields, $search) {
                        foreach ($fillableFields as $field) {
                            $query->orWhere($field, 'like', $search);
                        }
                    });
                });
            }
        );

        $query->when(
            $category_ids,
            function ($query) use ($category_ids) {
                $query->whereIn('category_id', $category_ids);
            }
        );

        $query->when(
            $category_id,
            function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            }
        );

        $query->when(
            $judge_id,
            function ($query) use ($judge_id,) {
                $query->where('judge_id', $judge_id,);
            }
        );

        $query->when(
            $candidate_id,
            function ($query) use ($candidate_id) {
                $query->where('candidate_id', $candidate_id);
            }
        );

    }

    public function scopeJudgeScore($query, $categoryId = null){
        $category_id = $categoryId ? $categoryId : Event::value('category_id');
        return $query->where('category_id', $category_id)
        ->where('judge_id', Auth::id());
    }

    public function scopeScoreByCategory($query)
    {
        $query->selectRaw('category_id, candidate_id, AVG(score) as average_score')
        ->groupBy('category_id', 'candidate_id')
        ->orderBy('average_score', 'DESC');
    }

    public function scopeGroupByCandidate($query)
    {
        $query->selectRaw('candidate_id, AVG(score) as average_score')
        ->groupBy('candidate_id')
        ->orderBy('average_score', 'DESC');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->useLogName($this->table)
        ->logOnlyDirty();
    }

    public function judge() : BelongsTo
    {
       return $this->BelongsTo(User::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function candidate() : BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
