<?php

namespace App\Models;

use App\Traits\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Role extends Model
{
    use HasFactory, HasUuids, Slug, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'description',
    ];

    const ROLE_JUDGE = 'Judge';
    const ROLE_ADMIN = 'Admin';
    const ROLE_SUPER_ADMIN = 'Super Admin';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->useLogName($this->table)
        ->logOnlyDirty();
    }
}
