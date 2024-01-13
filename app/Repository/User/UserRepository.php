<?php

namespace App\Repository\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Repository\Base\BaseRepository;
use Illuminate\Validation\ValidationException;
use App\Repository\User\UserRepositoryInterface;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->model->whereNot('role_id','8787fc94-01e7-4f3b-a988-3b29409d0b76')->get();
    }

    public function getUserByEmail(string $email): User
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return $user;
        } else {
            throw ValidationException::withMessages([
                'user_not_found' => 'User not found'
            ]);
        }
    }
}
