<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AnswerRequest;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(AnswerRequest $request, $id) {
        $request->merge([
            'question_id' => $id
        ]);
        Answer::create($request->all());
        return response()->json($request->all());
    }

    public function destroy($id) {
        $answer = Answer::find($id);
        $question = $answer->question;
        Answer::find($id)->delete();

        return redirect()->route('question.edit', [
            'question' => $question
        ]);
    }
}
