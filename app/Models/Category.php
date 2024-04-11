<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'percentage',
        'candidate_limit',
        'min_score',
        'max_score',
        'order',
        'isCurrent',
        'status',
        'description',
    ];

    public function scopeFilter($query)
    {
        $search = request('search') ?? false;
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
}
