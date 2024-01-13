<?php

namespace App\Models;

use App\Traits\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionGroup extends Model
{
    use HasFactory, HasUuids, Slug, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description'
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
