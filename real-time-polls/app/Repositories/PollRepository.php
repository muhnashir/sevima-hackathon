<?php

namespace App\Repositories;

use App\Models\Poll;

class PollRepository
{

    protected $poll;
    public function __construct(){
        $this->poll = new Poll();
    }

    public function Create(array $data){
        return $this->poll->create($data);
    }

    public function FindVotesByQuestionID(int $question_id)
    {
        return false;
    }

}
