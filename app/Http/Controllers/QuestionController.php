<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Question;
use App\Task;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $task = Task::find($id);
        return view('question.create', [
            'task' => $task
        ]);
    }

    /**
     * @param QuestionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request, $id) {
        $task = Task::find($id);
        $request->merge([
            'task_id' => $task->id
        ]);
        Question::create($request->all());

        return redirect()->route('task.index', [
            'paragraph' => $task->paragraph
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $question = Question::find($id);

        return view('question.edit', [
            'question' => $question,
            'task' => $question->task
        ]);
    }

    public function update(QuestionRequest $request, $id) {
        $question = Question::find($id);
        $question->fill($request->all());
        $question->save();

        return redirect()->route('task.index', [
            'paragraph' => $question->task->paragraph
        ]);
    }

    public function destroy($id) {
        $question = Question::find($id);
        $paragraph = $question->task->paragraph;
        Question::find($id)->delete();

        return redirect()->route('task.index', [
            'paragraph' => $paragraph
        ]);
    }
}
