<?php

namespace App\Services\Poll;

use App\Base\ServiceBase;
use App\Repositories\PollRepository;
use App\Responses\ServiceResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreatePollService extends ServiceBase
{
    protected $data;
    protected $pollRepository;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->pollRepository = new PollRepository();
    }

    /**
     * Validate the data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validate(){
        return Validator::make($this->data, [
            'question'           => 'required',
            'option'    => 'required',
        ]);
    }

    /**
     * main method of this service
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse {

        // validate the request data
        if ($this->validate()->fails()) {
            return self::error($this->validate()->errors()->getMessages(), implode(',',$this->validate()->errors()->all()),422);
        }

        try{

            $this->pollRepository->create([
                "question_id" => $this->data['question'],
                "question_option_id" => $this->data['option'],
            ]);

            return self::success(null, 'Berhasil Menjawab Pertanyaan');

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
