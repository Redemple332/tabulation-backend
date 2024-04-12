<?php

namespace App\Repository\Event;

use App\Models\Category;
use App\Models\Event;
use App\Repository\Base\BaseRepository;
use App\Repository\Event\EventRepositoryInterface;
use Illuminate\Validation\ValidationException;


class EventRepository extends BaseRepository implements EventRepositoryInterface
{

    /**
     * Event Repository constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function nextCategory()
    {

    //     $model = $this->model->find($id);
    //     if ($model){
    //         $model->update($data);
    //         return $model->fresh();
    //     } else{
    //         $this->notFound();
    //     }
      $nextCategory = $this->model->getNextCategoryAttribute();
      $model = $this->model->first();

      if($nextCategory && $model)
      {
         $model->update([
            'category_id' => $nextCategory->id
        ]);
        return $model->fresh();
      }
      $this->noNextCategory();
    }

    public function noNextCategory()
    {
        throw ValidationException::withMessages([
            'record_not_found' => "No next category!"
        ]);
    }
}
