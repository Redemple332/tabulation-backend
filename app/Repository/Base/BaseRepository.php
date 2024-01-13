<?php

namespace App\Repository\Base;

use App\Models\Document;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function filter(array $search = [])
    {
        return $this->model->filter($search)->get();
    }

    public function find($id, $with = []): ?Model
    {
        $record = $this->model->with($with)->find($id);
        if ($record) {
            return $record;
        } else{
            $this->notFound();
        }
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function update(array $data, $id)
    {
        $model = $this->model->find($id);
        if ($model){
            $model->update($data);
            return $model->fresh();
        } else{
            $this->notFound();
        }
    }

    public function delete(string $id, string $deletion_note = null)
    {
        $model = $this->model->find($id);
        if ($model) {
            if($deletion_note){
                $model->update(['deletion_note' =>  $deletion_note]);
            }
            $model->delete();
        } else{
            $this->notFound();
        }
    }

    public function restore(string $id)
    {
        $model = $this->model->onlyTrashed()->find($id);
        if ($model) {
            return $model->restore();
        } else{
            $this->notFound();
        }
    }

    public function getTrashed(array $relations = [], string $sortByColumn = 'created_at', string $sortByOrder = 'DESC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
        return $this->model->withTrashed()->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
    }

    public function getList(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortByOrder = 'DESC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
        return $this->model->filter($search)->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
        // return $this->model->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
    }

    public function getPermittedList(array $search = [], array $relations = [], string $user = '', string $form_type='' , string $sortByColumn = 'created_at', string $sortByOrder = 'DESC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
            //Different forms have their own different approvers and checkers, add the specific field here
            $formTypeColumns = [
                'COI' => ['approver_id'],
                'GH' => ['endorser_id','approver_id'],
                'TA' => ['approver_id']
                //'ABC'
                //TA
            ];

            $this->model = $this->model->where(function ($query) use ($user, $form_type, $formTypeColumns) {
                //Compares all fields to user_id, if the user is the author of the record.
                $query->where('user_id', $user);

                //Compare sa columns above ung model if the field is available using OR CLAUSE
                if (array_key_exists($form_type, $formTypeColumns)) {
                    $columns = $formTypeColumns[$form_type];
                    foreach ($columns as $column) {
                        $query->orWhere(function ($query) use ($column, $user) {
                            $query->where($column, $user);
                        });
                    }
                }

            });


            if($this->model === null){
                return 0;
            }
            return $this->model->filter($search)->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
    }

    public function getExportList(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortByOrder = 'ASC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
        return $this->model->filter($search)->orderBy($sortByColumn, $sortByOrder)->get();
    }

    public function getOptions(string $attribute, $key = 'id')
    {
        if(Schema::hasColumn($this->model->getTable(), $attribute)){
            return $this->model->select($key, $attribute)->get();
        } else{
            $this->notFound();
        }
    }

    public function notFound(){
        throw ValidationException::withMessages([
            'record_not_found' => "Record not found"
        ]);
    }

    public function saveDocuments(Model $model, array $data = []){
        $documents = [];

        if($model->documents){
            $model->documents()->delete();
        }

        foreach ($data as $document) {
            $documents[] = new Document([
                'user_id' => Auth::user()->id,
                'name' => $document['filename'],
                'path' => $document['path'],
                'filename' => $document['filename'],
                'description' => $document['description']
            ]);
        }

        return $model->documents()->saveMany($documents);
    }
}
