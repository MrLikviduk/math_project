<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $table = 'questions';

    protected $fillable = [
        'task_id', 'body'
    ];

    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function right_answers() {
        return $this->hasMany('App\Answer')->where('is_right', 1);
    }
}
