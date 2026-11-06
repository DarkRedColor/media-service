<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Response extends Controller
{
    public function responseImgOrFail($file)
    {
        $res = response("file not found", 400);
        if (count($file) > 0) {
            $file = $file[0];
            if (file_exists($file)) {
                $res =  response()->download($file);
            }
        }

        return $res;
    }
}
