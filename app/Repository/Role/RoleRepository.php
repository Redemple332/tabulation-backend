<?php

namespace App\Repository\Role;

use App\Models\Role;
use App\Repository\Base\BaseRepository;
use Illuminate\Support\Facades\Schema;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function all(){
        return $this->model->whereNot('name','SuperAdmin')->get();
    }

    public function getOptions(string $attribute, $key = 'id')
    {
        if(Schema::hasColumn($this->model->getTable(), $attribute)){
            return $this->model->select($key, $attribute)->whereNot('name','SuperAdmin')->get();
        } else{
            $this->notFound();
        }
    }
}