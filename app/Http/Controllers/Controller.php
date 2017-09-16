<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respond($message, $status, $payload = [])
    {
        $response = config('response.success');
        $response['code'] = $status;
        $response['message'] = empty($message)? $response['message'] : $message;
        $response['response'] = $payload;
        return response()->json($response, $status);
    }

}
