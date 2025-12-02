<?php

namespace App\Http\Controllers\User;

use App\Exports\User\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserOptionResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Imports\User\UserImport;
use App\Repository\User\UserRepositoryInterface;
use App\Services\Utils\ResponseServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'User';

    public function __construct(UserRepositoryInterface $modelRepository, ResponseServiceInterface $responseService)
    {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results =  $this->modelRepository->getList([request('search')], [], 'judge_no', 'ASC');
        return $this->responseService->successResponse(
            $this->name,
            new UserCollection($results)
        );
    }

    public function show($id)
    {
        $user = new UserResource($this->modelRepository->find($id));
        return $this->responseService->showResponse($this->name, $user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->modelRepository->create($request->validated());
        $user = new UserResource($user);
        return $this->responseService->storeResponse($this->name, $user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->modelRepository->update($request->validated(), $id);
        $user = new UserResource($user);
        return $this->responseService->updateResponse($this->name, $user);
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
        $users = UserOptionResource::collection($this->modelRepository->all());
        return $this->responseService->successResponse($this->name, $users);
    }

    public function assistant(Request $request)
    {
        $params =  $request->validate([
            'id' => 'required|exists:users,id',
            'is_need_assistant' => 'required|boolean'
        ]);

        $user = $this->modelRepository->update($params, $params['id']);
        $user = new UserResource($user);
        return $this->responseService->updateResponse($this->name, $user);
    }

    public function export(){

        $type = request('type');

        $results =  $this->modelRepository->getExportList([request('search')], []);
       if ($type == 'pdf') {
            $pdf = Pdf::loadView('pdf.permit.permit', compact('results'));
            return $pdf->download();
        } else {
            $results = Excel::download(new UserExport($results), $this->name.'.xlsx');
            return $results;
        }
    }

    public function import(Request $request){
        $params =  $request->validate([
            'file' => 'required|file|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ], [
            'file.mimetypes' => 'The file must be a file of type: .xlsx'
        ]);

        $file = $request['file']->store('import');
        $import = new UserImport;

        $import->import($file);
        $rowsImported = $import->getRowCount();


        if ($import->failures()->isNotEmpty()) {
            return response()->json(['response' => 'Imported! And have some errors!', 'errors' =>
            $import->failures()],  404);
        }else{

            if(!$import->isValidTemplate()){
                return $this->responseService->rejectResponse($this->name, 'Invalid Template!');
            }
            if($rowsImported > 0){
                return $this->responseService->showResponse($this->name, 'Uploaded successfully!');
            }else{
                return $this->responseService->showResponse($this->name, 'Uploaded successfully but empty template!');
            }

        }
    }

}
