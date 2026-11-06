<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function imgGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/quiz/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

}
