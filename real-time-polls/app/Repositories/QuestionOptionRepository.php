<?php

namespace App\Repositories;

use App\Models\QuestionOption;

class QuestionOptionRepository
{
    protected $question;

    public function __construct(){
        $this->questionOption = new QuestionOption();
    }

    public function Insert(array $data){
        return $this->questionOption->insert($data);
    }

}
