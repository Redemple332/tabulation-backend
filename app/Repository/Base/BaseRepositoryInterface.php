<?php

namespace App\Repository\Base;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    // index
    public function all();
    // show
    public function find($id): ?Model;
    // store
    public function create(array $data): Model;
    // update
    public function update(array $data, $id);
    // destroy or archive
    public function delete(string $id);
    // restore
    public function restore(string $id);

    public function updateOrCreate(array $attributes, array $values = []);

    public function getTrashed();

    public function getList();

    public function getPermittedList();

    public function filter();

    public function getExportList();

    public function getOptions(string $attribute);

    public function saveDocuments(Model $model, array $data);

}
