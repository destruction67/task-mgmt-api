<?php

namespace App\Services\tasklist;

use App\Http\Resources\MarkTaskRes;
use App\Http\Resources\TaskRes;
use App\Models\task\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskService
{

    public function getTasks(object $params)
    {
        try {
            $count = $params->count ?? 10;
            $searchValue = $params->searchValue ?? null;
            $status = $params->status ?? null;

            $tasks = Task::query()
                ->searchvalue($searchValue)
                ->active($status)
                ->paginate($count);

            $tasks->getCollection()->transform(function ($task) {
                return [
                    'id'          => $task->id,
                    'title'       => $task->title,
                    'description' => $task->description,
                    'status'      => $task->status,
                    'due_date'    => $task->formatted_due_date,
                ];
            });

            return $tasks;
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }

    public function markTaskAsCompleteOrIncomplete(object $params)
    {
        try {
            $task = Task::find($params->id);
            if ($task) {
                $task->status = $params->status;
                $task->save();

                $data['updatedMarkTask'] = new MarkTaskRes($task);
            }

            return $data;
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }


    public function createTask(array $params)
    {
        try {
            $task = new Task();
            $task->title = $params['title'];
            $task->description = $params['description'] ?? null;
            $task->status = false ?? null;
            $task->due_date = $params['due_date'] ?? null;
            $task->save();

            return $task;
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }

    public function findTask(int $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            return [
                'id'          => $task->id,
                'title'       => $task->title,
                'description' => $task->description,
                'status'      => $task->status,
                'due_date'    => $task->due_date,
            ];
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }

    public function updateTask(object $params, int $taskId)
    {
        try {
            $task = Task::find($taskId);
            $task->title = $params->title;
            $task->description = $params->description;
            $task->due_date = $params->due_date;

            $task->save();
            $data['updatedTask'] = new TaskRes($task);

//        Log::info('Task updated', ['spiderman' => $task]);
            return $data;
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }

    public function deleteTask(int $taskId)
    {
        try {
            $data = Task::findOrFail($taskId);
            $data->delete();

            return $data->toArray();
        } catch (Throwable $exception) {
            Log::channel('local-dev')->error($exception->getMessage());

            return false;
        }
    }

}
