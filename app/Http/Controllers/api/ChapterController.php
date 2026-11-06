<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ChapterController extends Controller
{
    public function imgGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/chapter/image/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function backgroundGet($host, $id)
    {
        $png = '/mnt/langlyphpapistorage/' . $host . '/chapter/background/' . $id;
        if (file_exists($png)) {
            return response()->download($png);
        } else {
            return response("file not found", 400);
        }
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
            if ($item['format']=='data:image/png;base64,') {

                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "chapter/image");

            }
            else {
                return response('bad format, needed png',400);
            }$this->deletePng($item['id'] . '_L' . '.png', $host);

        }

        return response("success", 200);
    }

    public function delPng($id,$host)
    {
        $this->deletePng($id . '_L.webp', $host);
        $this->deletePng($id . '_M.webp', $host);
        $this->deletePng($id . '_S.webp', $host);
        $this->deletePng($id . '_locked_L.webp', $host);
        $this->deletePng($id . '_locked_M.webp', $host);
        $this->deletePng($id . '_locked_S.webp', $host);
    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_chapter/image_uploads')->exists($name)) {
            Storage::disk($host . '_chapter/image_uploads')->delete($name);
        }
    }



    public function backgroundPost(Request $request)
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
            $dbHost = $item['host'];

            $host = 'uploads';

            if ($dbHost == "langly-php-postgresql-production.postgres.database.azure.com") {
                $host = 'production';
            }
            if ($dbHost == "langly-php-postgresql-development.postgres.database.azure.com") {
                $host = 'development';
            }
            if ($dbHost == "langly-php-postgresql-server.postgres.database.azure.com") {
                $host = 'trash';
            }
            $image = $item['file'];  // your base64 encoded
            if (Str::contains($image, 'data:image/png;base64,')) {
                $image = str_replace('data:image/png;base64,', '', $image);
                $format = '.png';
                $imageName = $item['time'] . '_' . $item['name'] . '.png';
            }
            if (Str::contains($image, 'data:image/jpeg;base64,')) {
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $format = '.jpeg';
                $imageName = $item['time'] . '_' . $item['name'] . '.jpeg';
            }
            if (Str::contains($image, 'data:image/jpg;base64,')) {
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $format = '.jpg';
                $imageName = $item['time'] . '_' . $item['name'] . '.jpg';
            }
            $image = str_replace(' ', '+', $image);
            Storage::disk($host . '_chapter_uploads_background')->put($imageName, base64_decode($image));

            $img = Image::make('/mnt/langlyphpapistorage/' . $host . '/chapter/background/' . $imageName);
            $img->crop(1242, 2688);
            $imageName = $item['time'] . '_' . $item['id'] . '_3x' . '.png';
            $img->save('/mnt/langlyphpapistorage/' . $host . '/chapter/background/' . $imageName);
            exec("../rusty_image_resize/target/release/rusty_image_resize --input " . '/mnt/langlyphpapistorage/' . $host . '/chapter/background/' . $imageName . " --height 1783 --output " . '/mnt/langlyphpapistorage/' . $host . '/chapter/background/' . $item['time'] . '_' . $item['id'] . '_2x' . $format . " --algorithm lanczos3");

        }

        return response('success', 200);
    }
}
