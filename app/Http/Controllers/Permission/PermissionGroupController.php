<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionGroupResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Repository\Permission\PermissionGroupRepositoryInterface;
use App\Http\Requests\PermissionGroup\StorePermissionGroupRequest;
use App\Http\Requests\PermissionGroup\UpdatePermissionGroupRequest;

class PermissionGroupController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Permission Group';

    public function __construct(PermissionGroupRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $permissionGroups = PermissionGroupResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $permissionGroups);
    }

    public function show($id)
    {
        $permissionGroup = new PermissionGroupResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $permissionGroup);
    }

    public function store(StorePermissionGroupRequest $request)
    {
        $permissionGroup = $this->modelRepository->create($request->validated());
        $permissionGroup = new PermissionGroupResource($permissionGroup);
        return $this->responseService->storeResponse($this->name, $permissionGroup);
    }

    public function update(UpdatePermissionGroupRequest $request, $id)
    {
        $permissionGroup = $this->modelRepository->update($request->validated(), $id);
        $permissionGroup = new PermissionGroupResource($permissionGroup);
        return $this->responseService->updateResponse($this->name, $permissionGroup);
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
}
