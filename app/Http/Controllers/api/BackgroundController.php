<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BackgroundController extends Controller
{
    public function archiveTest()
    {
        return response()->download('archive.zip');
    }

    public function backgroundGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/bg/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);

    }

    public function postBg(Request $request)
    {
        $files = $request->all();
        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $item) {
            if (!array_key_exists('file', $item) || $item['file'] == null) {
                return response('no file or wrong array key', 400);
            }
            $imgFunctions = new ImgAlgorithm();

            $host = $imgFunctions->hostCheck($item['host'] ?? null);

            $image = $item['file'];
            if ($item['format'] == "data:image/png;base64,") {
                $image = str_replace('data:image/png;base64,', '', $image);
                $imageNamePNGL = $item['id'] . '_L' . '.png';
                $imageNameL = $item['id'] . '_L' . '.webp';
                $image = str_replace(' ', '+', $image);
                Storage::disk($host . '_bg_uploads')->put($imageNamePNGL, base64_decode($image));
                $image = Image::make('/mnt/langlyphpapistorage/' . $host . '/bg/' . $imageNamePNGL);
                (string)$image->save('/mnt/langlyphpapistorage/' . $host . '/bg/' . $imageNameL, 94, 'webp');
                $image = Image::make('/mnt/langlyphpapistorage/' . $host . '/bg/' . $imageNameL);
                $imageNameM = $item['id'] . '_M' . '.webp';
                $imageNameS = $item['id'] . '_S' . '.webp';
            } else {
                return response('bad format',400);
            }

//            if ($item['oldname'] <> $item['name']) {
//                Storage::disk($host . '_bg_uploads')->delete($item['oldname'] . $format);
//                Storage::disk($host . '_bg_uploads')->delete($item['oldname'] . "_2x" . $format);
//                Storage::disk($host . '_bg_uploads')->delete($item['oldname'] . "_3x" . $format);
//            }
            $imgHeight = $image->height();
            $image->resize(null,$imgHeight*2/3,function ($constraint){
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . '/bg/' . $imageNameM);

            $image->resize(null,$imgHeight*1/3,function ($constraint){
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . '/bg/' . $imageNameS);

            $this->deletePng($imageNamePNGL, $host);

}

        return response('done', 200);

    }

    public function delPng($id,$host)
    {
        $this->deletePng($id . '_L.webp', $host);
        $this->deletePng($id . '_M.webp', $host);
        $this->deletePng($id . '_S.webp', $host);
    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_bg_uploads')->exists($name)) {
            Storage::disk($host . '_bg_uploads')->delete($name);
        }
    }
}
