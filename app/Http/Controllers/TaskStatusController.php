<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller
{
   

    public function index()
    {
        $statuses = TaskStatus::orderBy('id')->paginate();
        return view('statuses.index', compact('statuses'));
    }

    public function create(TaskStatus $taskStatus)
    {
        $this->authorize('create', $taskStatus);
        return view('statuses.create', ['status' => $taskStatus]);
    }

    public function store(Request $request)
    {
        $status = new TaskStatus();
        $status->name = $request->input('name');
        $status->save();
        return redirect()
            ->route('task_statuses.index')->with('success','Статус успешно создан');
    }

    public function edit(TaskStatus $taskStatus)
    {
        
        $this->authorize('update', $taskStatus);
        return view('statuses.edit', ['status' => $taskStatus]);
        
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $taskStatus->name = $request->input('name');
        $taskStatus->save();
        return redirect()
            ->route('task_statuses.index')->with('success','Статус успешно изменён');

    }

    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize('delete', $taskStatus);
        if ($taskStatus->tasks->all()) {
            return redirect()->route('task_statuses.index')->with('error', 'Не удалось удалить статус');
        }
        if ($taskStatus) {
            $taskStatus->delete();
          }
          return redirect()->route('task_statuses.index');
    }
}
