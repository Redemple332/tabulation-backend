<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Candidate extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'first_name',
        'last_name',
        'no',
        'gender',
        'age',
        'image',
        'contact',
        'address',
        'status',
        'description'
    ];

    public function getFullNameAttribute(){
        return $this->first_name.' '. $this->last_name;
    }



    public function scopeFilter($query)
    {
        $search = request('search') ?? false;
        $is_active = request('is_active') ?? false;

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

        $query->when($is_active,
            function ($query) use ($is_active) {
                $query->where('status', $is_active);
            }
        )->orderBy('no', 'ASC')->orderBy('gender', 'ASC');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->useLogName($this->table)
        ->logOnlyDirty();
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
