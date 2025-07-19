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
        return $this->create($data);
    }

}
