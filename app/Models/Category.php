<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'percentage',
        'min_score',
        'max_score',
        'order',
        'status',
        'description',
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeFilter($query)
    {
        $search = request('search') ?? false;
        $is_active = request('is_active') ?? false;
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

        $query->when($is_active,function ($query) use ($is_active) {
            $query->where('status', $is_active);
        });

        $query->when($category_id,function ($query) use ($category_id) {
            $query->where('id', $category_id);
        });
    }
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function($model){
            $model->order = Category::max('order') + 1;
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->useLogName($this->table)
        ->logOnlyDirty();
    }

    public function scores() : HasMany
    {
        return $this->hasMany(Score::class)->orderBy('candidate_id')->orderBy('judge_id');
    }

    public function candidates()
    {
        return $this->scores()->with('candidate')->get()->pluck('candidate')->unique();
    }
}
