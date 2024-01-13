<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Repository\Permission\PermissionRepositoryInterface;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Permission\SetPermissionPermissionRequest;


class PermissionController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Permission';

    public function __construct(PermissionRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $permissions = PermissionResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $permissions);
    }

    public function show($id)
    {
        $permission = new PermissionResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $permission);
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = $this->modelRepository->create($request->validated());
        $permission = new PermissionResource($permission);
        return $this->responseService->storeResponse($this->name, $permission);
    }

    public function update(StorePermissionRequest $request, $id)
    {
        $permission = $this->modelRepository->update($request->validated(), $id);
        $permission = new PermissionResource($permission);
        return $this->responseService->updateResponse($this->name, $permission);
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
        $permissions = $this->modelRepository->getPermissionOptions();
        return $this->responseService->successResponse($this->name, $permissions);
    }
}
