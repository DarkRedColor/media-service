<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EpisodeController extends Controller
{
    public function imageGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/episode/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function imageAdditionalGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/episode/additional/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function imagePost(Request $request)
    {
        $files = $request->all();
        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $item) {
            if (!array_key_exists('file', $item) || $item['file'] == null) {
                return response('no file or wrong array key', 400);
            }
            if (!array_key_exists('id', $item) || $item['id'] == null) {
                return response('no id or wrong array key', 400);
            }

            $imgFunctions = new ImgAlgorithm();

            $host = $imgFunctions->hostCheck($item['host'] ?? null);

            $image = $item['file'];  // your base64 encoded
            if ($item['format'] == 'data:image/png;base64,') {
                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "episode",true);

            } else {
                return response('bad format, needed png', 400);
            }
            $this->deletePng($item['id'] . '_L' . '.png', $host);

        }

        return response('success', 200);
    }

    public function imageAdditionalPost(Request $request)
    {
        $files = $request->all();
        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $item) {
            if (!array_key_exists('file', $item) || $item['file'] == null) {
                return response('no file or wrong array key', 400);
            }
            if (!array_key_exists('id', $item) || $item['id'] == null) {
                return response('no id or wrong array key', 400);
            }

            $imgFunctions = new ImgAlgorithm();

            $host = $imgFunctions->hostCheck($item['host'] ?? null);

            $image = $item['file'];  // your base64 encoded
            if ($item['format'] == 'data:image/png;base64,') {
                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "episode/additional",true);
            } else {
                return response('bad format, needed png', 400);
            }
            $this->deleteAdditionalPng($item['id'] . '_L' . '.png', $host);

        }

        return response('success', 200);
    }

    public function delPng($id,$host)
    {
        $this->deletePng($id . '_L.webp', $host);
        $this->deletePng($id . '_M.webp', $host);
        $this->deletePng($id . '_S.webp', $host);
    }

    public function delAdditionalPng($id,$host)
    {
        $this->deleteAdditionalPng($id . '_L.webp', $host);
        $this->deleteAdditionalPng($id . '_M.webp', $host);
        $this->deleteAdditionalPng($id . '_S.webp', $host);
    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_episode_uploads')->exists($name)) {
            Storage::disk($host . '_episode_uploads')->delete($name);
        }
    }

    private function deleteAdditionalPng($name, $host)
    {
        if (Storage::disk($host . '_episode/additional_uploads')->exists($name)) {
            Storage::disk($host . '_episode/additional_uploads')->delete($name);
        }
    }
}
