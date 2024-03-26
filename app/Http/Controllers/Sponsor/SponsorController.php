<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sponsor\SponsorResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Sponsor\SponsorRequest;
use App\Repository\Sponsor\SponsorRepositoryInterface;

class SponsorController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Sponsor';

    public function __construct(SponsorRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Sponsors = SponsorResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Sponsors);
    }

    public function show($id)
    {
        $Sponsor = new SponsorResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Sponsor);
    }

    public function store(SponsorRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $this->modelRepository->saveImage('sponsors', $request->image);
        $Sponsor = $this->modelRepository->create($validatedData);
        $Sponsor = new SponsorResource($Sponsor);
        return $this->responseService->storeResponse($this->name, $Sponsor);
    }

    public function update(SponsorRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $this->modelRepository->saveImage('sponsors', $request->image);
        $Sponsor = $this->modelRepository->update($validatedData, $id);
        $Sponsor = new SponsorResource($Sponsor);
        return $this->responseService->updateResponse($this->name, $Sponsor);
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
         $Sponsors = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Sponsors);
    }
}
