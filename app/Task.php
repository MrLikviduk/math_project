<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table = 'tasks';

    protected $fillable = [
        'title', 'paragraph_id'
    ];

    public function paragraph() {
        return $this->belongsTo('App\Paragraph');
    }

    public function questions() {
        return $this->hasMany('App\Question');
    }
}
