<?php

namespace App\Http\Controllers;

use App\Services\Poll\CreatePollService;
use App\Services\Poll\ResultPollService;
use App\Services\Question\CreateQuestionService;
use App\Services\Question\FindQuestionService;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function polling($uuid)
    {
        $service = (new FindQuestionService($uuid))->call();
        abort_if($service->status != 200, 404,$service->message);
        $data = $service->data;
        return view('polls.create-poll',compact('data'));
    }

    public function store(Request $request, $uuid)
    {
        $service = (new CreatePollService($request->all()))->call();
        if($service->status == 422) return back()->withInput()->withError($service->message);
        throw_if($service->status != 200, $service->message);

        $resultService = (new ResultPollService($uuid))->call();
        $pollData = $resultService->status == 200 ? $resultService->data : [];

        \Log::info('Dispatching PollCreated event', [
            'uuid' => $uuid,
            'pollData' => $pollData
        ]);

        event(new \App\Events\PollCreated($uuid, $pollData));

        \Log::info('PollCreated event dispatched');

        return redirect(route('result-poll',[
            "uuid" => $uuid,
        ]))->withSuccess($service->message);
    }

    public function resultPoll($uuid)
    {
        $service = (new FindQuestionService($uuid))->call();
        abort_if($service->status != 200, 404,$service->message);
        $data = $service->data;
        return view('polls.result-poll', compact('data'));
    }

    public function apiResultPoll($uuid)
    {
        $service = (new ResultPollService($uuid))->call();
        abort_if($service->status != 200, 404,$service->message);
        if ($service->status != 200) {
            return response()->json([
                'status' => 'error',
                'message' => $service->message
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $service->data
        ]);
    }


}
