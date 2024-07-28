<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * This function retrieves a paginated list of tasks from the database and returns it as a JSON response.
     * The number of tasks per page is determined by the 'per_page' query parameter, with a default value of 10.
     * The response includes a success message and the HTTP status code 200 (OK).
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the task list.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $tasks = \App\Models\Task::paginate($perPage);
        $data  = TaskResource::collection($tasks);

        return $this->sendSuccessResponse($data, 'Task List', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $task = auth()->user()->tasks()->create($request->all());

            $data = TaskResource::make($task);
            DB::commit();

            return $this->sendSuccessResponse($data, 'Task created', Response::HTTP_OK);
        }catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            dd($th);
        }
        return $this->sendErrorResponse(message: 'Something went wrong',status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($task)
    {
        try {
            $task  = Task::findOrFail($task);
            $data = TaskResource::make($task);
            return $this->sendSuccessResponse($data, 'Task List', Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th);
        }
        return $this->sendErrorResponse(message: 'Task Not found',status: Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task)
    {
        DB::beginTransaction();
        try {

            $task = auth()->user()->tasks()->findOrFail($task);
            $task->update($request->validated());
            $data = TaskResource::make($task);
            DB::commit();

            return $this->sendSuccessResponse($data, 'Task Updated', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
        }
        return $this->sendErrorResponse(message: 'Something went wrong',status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($task)
    {
        DB::beginTransaction();
        try {
            $task = \App\Models\Task::findOrFail($task);
            $task->delete();
            DB::commit();

            return $this->sendSuccessResponse([], 'Task deleted', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
        }
        return $this->sendErrorResponse(message: 'Something went wrong',status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
