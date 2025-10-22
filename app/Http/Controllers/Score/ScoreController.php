<?php

namespace App\Http\Controllers\Score;

use App\Http\Controllers\Controller;
use App\Http\Resources\Score\ScoreResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Score\ScoreRequest;
use App\Http\Resources\Score\ScoreByCategoryResources;
use App\Http\Resources\Score\ScoreOverAllResource;
use App\Models\Event;
use App\Repository\Score\ScoreRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    public function scoreByCategory()
    {
        $Score =  $this->modelRepository->getScoreByCategory();
        $Score = ScoreByCategoryResources::collection($Score);
        return $this->responseService->successResponse($this->name, $Score);
    }

    public function overAll()
    {
        $Score =  $this->modelRepository->getOverAll();
        //$Score = ScoreOverAllResource::collection($Score);
        return $this->responseService->successResponse($this->name, $Score);
    }

    public function overAllExport(Request $request)
    {
        // $results = ScoreOverAllResource::collection($results);
        // $results = $results->toArray(request());

        $results =  $this->modelRepository->getOverAll();
        $event = Event::where('id', '9955ffde-c38c-449a-9a27-3ebac65d405d')->first();
        return Pdf::loadView('pdf.score.over-all', compact('results', 'event'))->setPaper('a4', 'portrait')->stream();
    }

    public function submitScoreJudge(ScoreRequest $request)
    {
        $Score = $this->modelRepository->submitScoreJudge($request->validated());
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


}
