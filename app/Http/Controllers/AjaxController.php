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
        foreach ($params['ans'] as $q_id => $a_ids) {
            $question = Question::find($q_id);
            $right_answers = $question->right_answers;
            $v = TRUE;
            foreach ($right_answers as $right_answer) {
                if (!in_array($right_answer->id, $a_ids)) {
                    $v = FALSE;
                    break;
                }
            }
            foreach ($a_ids as $a_id) {
                if (!$right_answers->contains($a_id)) {
                    $v = FALSE;
                    break;
                }
            }
            if ($v)
                $count_right++;
        }
        return response()->json(['count_questions' => $count_questions, 'count_right' => $count_right], 200);
    }
}