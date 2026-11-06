<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WordController extends Controller
{
    public function audioGet($host, $id)
    {
        if (Storage::disk($host . '_word/audio' . '_uploads')->exists($id)) {
            return Storage::disk($host . '_word/audio' . '_uploads')->download($id);
        }
        return response("file not found", 400);
    }

    public function delAudio($id, $host)
    {
        $this->deleteAudio($id, $host);
    }

    private function deleteAudio($name, $host)
    {
        if (Storage::disk($host . '_word/audio_uploads')->exists($name)) {
            Storage::disk($host . '_word/audio_uploads')->delete($name);
        }
    }

    public function imgGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/word/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function imgPost(Request $request)
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

                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "word", false);

            } else {
                return response('bad format, needed png', 400);
            }


            $this->deletePng($item['id'] . '_L' . '.png', $host);

        }
        return response('success', 200);
    }

    public function delPng($id, $host)
    {
        $this->deletePng($id . '_L.webp', $host);
        $this->deletePng($id . '_M.webp', $host);
        $this->deletePng($id . '_S.webp', $host);
    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_word_uploads')->exists($name)) {
            Storage::disk($host . '_word_uploads')->delete($name);
        }
    }
}
