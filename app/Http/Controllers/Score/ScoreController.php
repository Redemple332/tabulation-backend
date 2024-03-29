<?php

namespace App\Http\Controllers\Score;

use App\Http\Controllers\Controller;
use App\Http\Resources\Score\ScoreResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Score\ScoreRequest;
use App\Repository\Score\ScoreRepositoryInterface;

class ScoreController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'Score';

    public function __construct(ScoreRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $Scores = ScoreResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $Scores);
    }

    public function show($id)
    {
        $Score = new ScoreResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $Score);
    }

    public function store(ScoreRequest $request)
    {
        $Score = $this->modelRepository->create($request->validated());
        $Score = new ScoreResource($Score);
        return $this->responseService->storeResponse($this->name, $Score);
    }

    public function update(ScoreRequest $request, $id)
    {
        $Score = $this->modelRepository->update($request->validated(), $id);
        $Score = new ScoreResource($Score);
        return $this->responseService->updateResponse($this->name, $Score);
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
         $Scores = $this->modelRepository->getOptions('name');
        return $this->responseService->successResponse($this->name, $Scores);
    }
}
