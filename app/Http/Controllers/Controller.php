<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data)
    {
        return response([
            "type" => "success",
            "message" => "Successful",
            "data" => $data
        ], 200);
    }
    public function error($message, $extra)
    {
        return response([
            "type" => "error",
            "message" => $message,
            "data" => $extra
        ], 403);
    }
}
