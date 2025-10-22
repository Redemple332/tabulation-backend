<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Utils\ResponseServiceInterface;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoryScoreResource;
use App\Models\Event;
use App\Repository\Category\CategoryRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
        $Categories = CategoryResource::collection($this->modelRepository->getList([], [], 'order','ASC'));
        return $this->responseService->successResponse($this->name, $Categories);
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

    public function scores()
    {
        $results = CategoryScoreResource::collection($this->modelRepository->getList([], ['scores','scores.judge'], 'order','ASC'));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function export(Request $request)
    {
        // $request->validate([
        //     'category_id' => 'required|uuid'
        // ]);
        $event = Event::where('id', '9955ffde-c38c-449a-9a27-3ebac65d405d')->first();
        $results = CategoryScoreResource::collection($this->modelRepository->getList([], ['scores','scores.judge'], 'order','ASC'));
        $results = $results->toArray(request());
        return Pdf::loadView('pdf.score.index', compact('results', 'event'))
        ->setPaper('a4', 'portrait')
        ->download('scores.pdf');
    }
}
