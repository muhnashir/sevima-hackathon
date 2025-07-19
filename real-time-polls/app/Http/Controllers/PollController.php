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
//        $service = (new CreatePollService($request->all()))->call();
//        if($service->status == 422) return back()->withInput()->withError($service->message);
//        throw_if($service->status != 200, $service->message);

        event(new \App\Events\PollCreated($uuid, []));

        return redirect(route('result-poll',[
            "uuid" => $uuid,
//        ]))->withSuccess($service->message);
        ]))->withSuccess("berhasil");
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
        $data = $service->data;
        return view('polls.result-poll', compact('data'));
    }


}
