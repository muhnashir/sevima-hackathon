<?php

namespace App\Services\Poll;

use App\Base\ServiceBase;
use App\Repositories\PollRepository;
use App\Repositories\QuestionRepository;
use App\Responses\ServiceResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ResultPollService extends ServiceBase
{
    protected $uuid;
    protected $pollRepository;
    protected $questionRepository;
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
        $this->pollRepository = new PollRepository();
        $this->questionRepository = new QuestionRepository();
    }


    /**
     * main method of this service
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse {
        try{

            $question = $this->questionRepository->FindWithOptios($this->uuid);
            $pollResults = $this->pollRepository->FindVotesByQuestionID($question->id);

            $formattedResults = [
                'question' => [
                    'id' => $question->id,
                    'uuid' => $question->uuid,
                    'name' => $question->name,
                    'finish_at' => $question->finish_at,
                    'options' => $question->options->map(function($option) use ($pollResults, $question) {
                        $votes = 0;
                        if (isset($pollResults[$question->id]) && isset($pollResults[$question->id][$option->id])) {
                            $votes = $pollResults[$question->id][$option->id]->votes;
                        }
                        return [
                            'id' => $option->id,
                            'name' => $option->name,
                            'votes' => $votes
                        ];
                    })
                ]
            ];

            return self::success([
                'votes' => $formattedResults,
            ], 'success');

        }catch (Exception $th) {

            report($th);

            Log::error(self::class . __FUNCTION__, [
                'Message ' => $th->getMessage(),
                'On file ' => $th->getFile(),
                'On line ' => $th->getLine()
            ]);

            return self::error(null, $th->getMessage());

        }

    }
}
