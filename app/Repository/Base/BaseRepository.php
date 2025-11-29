<?php

namespace App\Repository\Base;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        return $this->model->withTrashed()->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 100);
    }

    public function getList(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortByOrder = 'DESC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
        return $this->model->filter($search)->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 100);
        // return $this->model->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
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

    public function saveImage(string $folder, ?string $image){

        if($image)
        {
            $image_extension = '';
            if (strpos($image, 'data:image/png;base64,') === 0) {
                $image_extension = 'png';
            } elseif (strpos($image, 'data:image/jpeg;base64,') === 0) {
                $image_extension = 'jpg';
            } elseif (strpos($image, 'data:image/gif;base64,') === 0) {
                $image_extension = 'gif';
            }

            if($image_extension) {
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace('data:image/gif;base64,', '', $image);
                $image = str_replace(' ', '+', $image);

                $imageName = Str::random(20) . '.' . $image_extension;

                $targetDir = env('APP_NAME').'/images/'.$folder;
                $publicPath = public_path($targetDir);

                if (!File::exists($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }
                $fullImagePath = $publicPath . '/' . $imageName;
                File::put($fullImagePath, base64_decode($image));
                return $imageName;
            }
        }
        return null;
    }
}
