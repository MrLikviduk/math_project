<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Paragraph;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($p_id) {
        $paragraph = Paragraph::find($p_id);
        return view('task.index', [
            'paragraph' => $paragraph
        ]);
    }

    public function create($p_id) {
        $paragraph = Paragraph::find($p_id);
        return view('task.create', [
            'paragraph' => $paragraph
        ]);
    }

    public function store(TaskRequest $request, $p_id) {
        $task = new Task();
        $task->fill($request->all());
        $task->paragraph_id = $p_id;
        $task->save();

        return redirect()->route('task.index', ['p_id' => $p_id]);
    }

    public function edit($p_id, $id) {
        $p = Paragraph::find($p_id);
        $task = Task::find($id);
        return view('task.edit', [
            'paragraph' => $p,
            'task' => $task
        ]);
    }

    public function update(TaskRequest $request, $id) {
        $task = Task::find($id);
        $p_id = $task->paragraph_id;
        $task->fill($request->all());
        $task->save();

        return redirect()->route('task.index', ['p_id' => $p_id]);
    }

    public function destroy($id) {
        $task = Task::find($id);
        $p_id = $task->paragraph_id;
        $task->delete();

        return redirect()->route('task.index', ['p_id' => $p_id]);
    }
}
