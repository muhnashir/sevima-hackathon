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
        $polls = $this->poll
            ->where('question_id', $question_id)
            ->select('question_id', 'question_option_id', \DB::raw('count(1) as votes'))
            ->groupBy('question_id', 'question_option_id')
            ->get();

        $groupedPolls = $polls->groupBy('question_id')->map(function ($questionPolls) {
            return $questionPolls->keyBy('question_option_id');
        });

        return $groupedPolls;
    }

}
