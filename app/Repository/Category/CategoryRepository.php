<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Base\BaseRepository;
use Illuminate\Validation\ValidationException;
use App\Repository\Category\CategoryRepositoryInterface;


class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * CategoryRepository constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

}
