<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Image\StoreImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        return view('images.import');
    }
    public function store(Request $request)
    {
        $service = (new StoreImageService($request->all()))->call();
        if($service->status == 422) return back()->withInput()->withError($service->message);
        throw_if($service->status != 200, $service->message);
        return redirect(route('index'))->withSuccess($service->message);
    }
}
