<?php

namespace App\Http\Controllers\tasklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\tasklist\AddTaskRequest;
use App\Http\Requests\tasklist\UpdateTaskRequest;
use App\Models\HttpCode;
use App\Models\StringConst;
use App\Services\tasklist\TaskService;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        try {
            $tasks = $this->taskService->getTasks($request);

            return response()->json($tasks, HttpCode::SUCCESS_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

    public function markTaskAsCompleteOrIncomplete(Request $request)
    {
        try {
            $task = $this->taskService->markTaskAsCompleteOrIncomplete($request);

            return response()->json($task, HttpCode::SUCCESS_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

    public function store(AddTaskRequest $request)
    {
        try {
            $validateData = $request->validated();
            $task = $this->taskService->createTask($validateData);

            return $task
                ? response()->json($task, HttpCode::SUCCESS_CREATED)
                : response()->json(StringConst::ERROR_RECORD_EXIST, HttpCode::BAD_REQUEST);
        } catch (ValidationException $exception) {
            return response()->json($exception, HttpCode::UNPROCESSABLE_ENTITY);
        } catch (ModelNotFoundException $exception) {
            return response()->json($exception->getMessage(), HttpCode::NOT_FOUND);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $taskId)
    {
        try {
            $task = $this->taskService->findTask($taskId);

            return response()->json($task, HttpCode::SUCCESS_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json($exception->getMessage(), HttpCode::NOT_FOUND);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

    public function update(UpdateTaskRequest $request, int $taskId)
    {
        try {
            $validateData = (object)$request->validated();
            $task = $this->taskService->updateTask($validateData, $taskId);

            return response()->json($task, HttpCode::SUCCESS_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

    public function destroy(int $taskId)
    {
        try {
            $user = $this->taskService->deleteTask($taskId);

            return response()->json($user,HttpCode::SUCCESS_OK);

        } catch (ModelNotFoundException $exception) {
            return response()->json($exception->getMessage(), HttpCode::NOT_FOUND);

        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), HttpCode::SERVICE_UNAVAILABLE);
        }
    }

}
