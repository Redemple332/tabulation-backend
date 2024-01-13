<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repository\Role\RoleRepositoryInterface;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Role\SetRolePermissionRequest;
use App\Http\Resources\Role\RoleResource;
use App\Repository\Role\RolePermissionRepositoryInterface;

class RoleController extends Controller
{
    private $modelRepository;
    private $rolePermissionRepository;
    private $responseService;
    private $name = 'Role';

    public function __construct(RoleRepositoryInterface $modelRepository, RolePermissionRepositoryInterface $rolePermissionRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->rolePermissionRepository = $rolePermissionRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $roles = RoleResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $roles);
    }

    public function show($id)
    {
        $role = new RoleResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $role);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->modelRepository->create($request->validated());
        $role = new RoleResource($role);
        return $this->responseService->storeResponse($this->name, $role);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->modelRepository->update($request->validated(), $id);
        $role = new RoleResource($role);
        return $this->responseService->updateResponse($this->name, $role);
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
        $roles = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $roles);
    }

    public function setRolePermission(SetRolePermissionRequest $request) {
        $permissions = $this->rolePermissionRepository->setRolePermissions($request->validated());
        return $this->responseService->updateResponse('Role Permission', $permissions);
    }

    public function updateRolePermission(Request $request) {
        $status = $this->rolePermissionRepository->updateRolePermission($request->all());
        return $this->responseService->updateResponse('Role Permission', $status);
    }
}
