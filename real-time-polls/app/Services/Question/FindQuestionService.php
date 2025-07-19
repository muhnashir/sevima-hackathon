<?php

namespace App\Services\Question;

use App\Base\ServiceBase;
use App\Repositories\QuestionRepository;
use App\Responses\ServiceResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class FindQuestionService extends ServiceBase
{

    protected $uuid;
    protected $questionRepository;
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
        $this->questionRepository = new QuestionRepository();
    }


    /**
     * main method of this service
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse {

        try{

            $data = $this->questionRepository->FindWithOptios($this->uuid);
            if (is_null($data)) {
                return self::error(null, 'Question not found', 404);
            }
            //Valid
            $finishAt = Carbon::parse($data->finish_at)->setTimezone('Asia/Jakarta');
            $isExpired = false;
            if ($finishAt->isPast()) {
                $isExpired = true;
            }

            return self::success([
                'data' => $data,
                'is_expired' => $isExpired
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
