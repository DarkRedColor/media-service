<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function imgGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/file/text/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }
    public function videoGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/file/video/' . $id);

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function imgPost(Request $request)
    {
        $files = $request->all();
        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $key => $item) {
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
                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "file/text", false);
            } else {
                return response('bad format, needed png', 400);
            }

            $this->deletePng($item['id'] . '_0_L' . '.png', $host);
            $this->deletePng($item['id'] . '_1_L' . '.png', $host);

        }
        return response('success', 200);
    }

    public function delPng($id, $host)
    {
        $this->deletePng($id . '_0_L.webp', $host);
        $this->deletePng($id . '_0_M.webp', $host);
        $this->deletePng($id . '_0_S.webp', $host);
        $this->deletePng($id . '_1_L.webp', $host);
        $this->deletePng($id . '_1_M.webp', $host);
        $this->deletePng($id . '_1_S.webp', $host);
    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_file/text_uploads')->exists($name)) {
            Storage::disk($host . '_file/text_uploads')->delete($name);
        }
    }

    public function audioPost(Request $request)
    {
        if ($request->hasFile('audio')) {
            $host = $request->host;
            $imgFunctions = new ImgAlgorithm();
            $host = $imgFunctions->hostCheck($host ?? null);
            if (isset($request['name'])) {
                $name = $request['name'];
                $audio = $request->file('audio');
                Storage::disk($host . '_file/audio' . '_uploads')->putFileAs('/', $audio, $name);
            } else {
                $audio = $request->file('audio');
                $name = str_replace(' ', '_', $audio->getClientOriginalName());
                Storage::disk($host . '_file/audio' . '_uploads')->putFileAs('/', $audio, $name);
            }
            $url = $request->header('referer') . 'admin/files/audio';
            return redirect($url);
        } else {
            return response('no file', 400);
        }
    }

    public function audioGet($host, $id)
    {
        if (Storage::disk($host . '_file/audio' . '_uploads')->exists($id)) {
            return Storage::disk($host . '_file/audio' . '_uploads')->download($id);
        }
        return response("file not found", 400);
    }

    public function delAudio($id, $host)
    {
        $this->deleteAudio($id, $host);
    }

    private function deleteAudio($name, $host)
    {
        if (Storage::disk($host . '_file/audio_uploads')->exists($name)) {
            Storage::disk($host . '_file/audio_uploads')->delete($name);
        }
    }
    public function delVideo($id, $host)
    {
        $this->deleteVideo($id, $host);
    }

    private function deleteVideo($name, $host)
    {
        if (Storage::disk($host . '_file/video_uploads')->exists($name)) {
            Storage::disk($host . '_file/video_uploads')->delete($name);
        }
    }
}
