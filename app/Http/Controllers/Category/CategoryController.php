<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Repository\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Category';

    public function __construct(CategoryRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Categorys = CategoryResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Categorys);
    }

    public function show($id)
    {
        $Category = new CategoryResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Category);
    }

    public function store(CategoryRequest $request)
    {
        $Category = $this->modelRepository->create($request->validated());
        $Category = new CategoryResource($Category);
        return $this->responseService->storeResponse($this->name, $Category);
    }

    public function update(CategoryRequest $request, $id)
    {
        $Category = $this->modelRepository->update($request->validated(), $id);
        $Category = new CategoryResource($Category);
        return $this->responseService->updateResponse($this->name, $Category);
    }

    public function destroy($id)
    {
        $this->modelRepository->delete($id);
        return $this->responseService->deleteResponse($this->name);
    }

    public function restore($id)
    {
        $this->modelRepository->restore($id);
        return $this->responseService->restoreResponse($this->name);
    }

    public function getOptions()
    {
         $Categorys = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Categorys);
    }
}
