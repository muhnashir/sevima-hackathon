<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    protected $question;

    public function __construct(){
        $this->question = new Question();
    }

    public function Create(array $data){
        return $this->question->create($data);
    }

    public function FindWithOptios($uuid){
        return $this->question->select(['uuid','id','name', 'finish_at'])->where('uuid', $uuid)->with(['options:id,name,question_id'])->first();
    }

}
