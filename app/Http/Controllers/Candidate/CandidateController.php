<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Resources\Candidate\CandidateResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Candidate\CandidateRequest;
use App\Repository\Candidate\CandidateRepositoryInterface;

class CandidateController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Candidate';

    public function __construct(CandidateRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Candidates = CandidateResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Candidates);
    }

    public function show($id)
    {
        $Candidate = new CandidateResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Candidate);
    }

    public function store(CandidateRequest $request)
    {
        $Candidate = $this->modelRepository->create($request->validated());
        $Candidate = new CandidateResource($Candidate);
        return $this->responseService->storeResponse($this->name, $Candidate);
    }

    public function update(CandidateRequest $request, $id)
    {
        $Candidate = $this->modelRepository->update($request->validated(), $id);
        $Candidate = new CandidateResource($Candidate);
        return $this->responseService->updateResponse($this->name, $Candidate);
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
         $Candidates = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Candidates);
    }
}
