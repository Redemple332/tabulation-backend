<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Event\EventRequest;
use App\Repository\Event\EventRepositoryInterface;

class EventController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Event';

    public function __construct(EventRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Events = EventResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Events);
    }

    public function show($id)
    {
        $Event = new EventResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Event);
    }

    public function store(EventRequest $request)
    {
        $Event = $this->modelRepository->create($request->validated());
        $Event = new EventResource($Event);
        return $this->responseService->storeResponse($this->name, $Event);
    }

    public function update(EventRequest $request, $id)
    {
        $Event = $this->modelRepository->update($request->validated(), $id);
        $Event = new EventResource($Event);
        return $this->responseService->updateResponse($this->name, $Event);
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
         $Events = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Events);
    }
}
