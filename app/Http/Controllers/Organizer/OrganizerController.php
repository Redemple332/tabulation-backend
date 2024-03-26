<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Organizer\OrganizerResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Organizer\OrganizerRequest;
use App\Repository\Organizer\OrganizerRepositoryInterface;

class OrganizerController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Organizer';

    public function __construct(OrganizerRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Organizers = OrganizerResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Organizers);
    }

    public function show($id)
    {
        $Organizer = new OrganizerResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Organizer);
    }

    public function store(OrganizerRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $this->modelRepository->saveImage('organizers', $request->image);
        $Organizer = $this->modelRepository->create($validatedData);
        $Organizer = new OrganizerResource($Organizer);
        return $this->responseService->storeResponse($this->name, $Organizer);
    }

    public function update(OrganizerRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $this->modelRepository->saveImage('organizers', $request->image);
        $Organizer = $this->modelRepository->update($validatedData, $id);
        $Organizer = new OrganizerResource($Organizer);
        return $this->responseService->updateResponse($this->name, $Organizer);
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
         $Organizers = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Organizers);
    }
}
