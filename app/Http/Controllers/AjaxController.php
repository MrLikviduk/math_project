<?php
namespace App\Http\Controllers;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AjaxController extends Controller {
    public function index(Request $request){
        $params = $request->all();
        $count_right = 0;
        $count_questions = count($params['ans']);
        foreach ($params['ans'] as $q_id => $a_id) {
            $question = Question::find($q_id);
            $answer = Answer::find($a_id);
            if ($answer->question_id = $question->id && $answer->is_right == 1) {
                $count_right++;
            }
        }
        return response()->json(['count_questions' => $count_questions, 'count_right' => $count_right], 200);
    }
}