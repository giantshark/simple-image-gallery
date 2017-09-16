<?php

namespace App\Container\Gallery\Controllers\Api;

use App\Container\Gallery\Models\Gallery;
use App\Container\Gallery\Services\UploadService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiGalleryController extends Controller
{

    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        $galleries = Gallery::get();
        return $this->respond([], 200, $galleries);
    }

    public function store(Request $request)
    {
        $rules = [
            'file' => config('validate.image_ext')
        ];
        $validator = Validator::make($request->only('file'), $rules);
        if (!$validator->passes()) return $this->respond($validator->errors()->all(), 400, []);
        $image = $this->uploadService->uploadImage(Auth::user(), $request->file);
        return $this->respond([], 200, [$image]);
    }

    public function delete($id)
    {
        $rules = [
            'id' => 'required|integer'
        ];
        $validator = Validator::make(['id' => $id], $rules);
        if (!$validator->passes()) return $this->respond($validator->errors()->all(), 400, []);
        if ($this->uploadService->removeImage($id)) {
            return $this->respond([], 200, []);
        }
        return $this->respond([config('error_message.image_not_found.th')], 400, []);
    }

}
