<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    public $table = 'paragraphs';

    protected $fillable = [
        'body', 'title'
    ];

    public function tasks() {
        return $this->hasMany('App\Task');
    }
}