<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'contact',
        'address',
        'email',
        'password',
        'judge_no',
        'is_active',
        'is_need_assistant',
        'category_id',
        'description',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['full_name'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }

    public function getisDoneVotingAttribute(){
        $category_id = Event::value('category_id');

        $scoreCount = Score::where('category_id', $category_id)
                           ->where('judge_id', Auth::id())
                           ->count();
        return $scoreCount > 0;
    }

    public function getisVotedAttribute(){
        $category_id = Event::value('category_id');
    }

    public function scopeFilter($query)
    {
        $search = request('search') ?? false;
        $isJudges = request('isJudges') ?? false;

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
        $query->when($isJudges,
        function ($query) {
            $query->where('role_id', "b9612992-1e02-4572-b618-6bcd60d651ac");
        }
    );
    }

    public function scores() : HasMany
    {
        return $this->hasMany(Score::class, 'judge_id');
    }

    public function scoresCurrentCategory() : HasMany
    {
        $category_id = Event::value('category_id');
        return $this->hasMany(Score::class, 'judge_id')->where('category_id', $category_id);
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '. $this->last_name;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function category() : BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->useLogName($this->table)
         ->logOnlyDirty();
    }
}
