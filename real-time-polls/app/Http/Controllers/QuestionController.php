<?php

namespace App\Http\Controllers;

use App\Services\Question\CreateQuestionService;
use App\Services\Question\FindQuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        return view('questions.create');
    }

    public function store(Request $request){

        $service = (new CreateQuestionService($request->all()))->call();
        if($service->status == 422) return back()->withInput()->withError($service->message);
        throw_if($service->status != 200, $service->message);

        return redirect(route('question.show',[
            "uuid" => $service->data['uuid'],
        ]))->withSuccess($service->message);
    }

    public function show($uuid)
    {
        $service = (new FindQuestionService($uuid))->call();
        abort_if($service->status != 200, 404,$service->message);
        $data = $service->data;
        return view('questions.detail',compact('data'));
    }
}
