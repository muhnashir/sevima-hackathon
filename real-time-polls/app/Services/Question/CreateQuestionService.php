<?php

namespace App\Services\Question;

use App\Base\ServiceBase;
use App\Repositories\QuestionOptionRepository;
use App\Repositories\QuestionRepository;
use App\Responses\ServiceResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateQuestionService extends ServiceBase
{

    protected $data;
    protected $questionRepository;
    protected $questionOptionRepository;
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->questionRepository = new QuestionRepository();
        $this->questionOptionRepository = new QuestionOptionRepository();

    }

    /**
     * Validate the data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validate() {
        return Validator::make($this->data, [
            'name'     => 'required|string|max:255',
            'finish_at' => 'required|date',
            'options' => 'required|array',
            'options.*' => 'required|string|max:255',
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
            DB::beginTransaction();
            //Create Question
            $question = $this->questionRepository->create([
                "name" => $this->data['name'],
                "finish_at" => $this->data['finish_at'],
            ]);

            $options = [];
            if (!empty($this->data['options'])) {
                foreach ($this->data['options'] as $option) {
                    $options[] = [
                        "question_id" => $question->id,
                        "name" => $option,
                    ];
                }
            }
            //Create Question Options
            $this->questionOptionRepository->insert($options);

            DB::commit();
            return self::success([
                "uuid" => $question->uuid,
            ], 'Berhasil Membuat Pertanyaan');

        }catch (Exception $th) {

            DB::rollBack();
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
