<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SubChapterController extends Controller
{
    public function lockedGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);
    }

    public function unlockedGet($host, $id)
    {
        $png = '/mnt/langlyphpapistorage/' . $host . '/sub-chapters/unlocked/' . $id;
        if (file_exists($png)) {
            return response()->download($png);
        } else {
            return response("file not found", 400);
        }
    }

    public function backgroundGet($host, $id)
    {
        $png = '/mnt/langlyphpapistorage/' . $host . '/sub-chapter/background/' . $id;
        if (file_exists($png)) {
            return response()->download($png);
        } else {
            return response("file not found", 400);
        }
    }

    public function lockedPost(Request $request)
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
                $imgFunctions->pngConvertAdventures($image, $host, $item['id'], "sub-chapter");

            } else {
                return response('bad format, needed png', 400);
            }
            $this->deletePng($item['id'] . '_L' . '.png', $host);

        }

        return response('success', 200);
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
        if (Storage::disk($host . '_sub-chapter_uploads')->exists($name)) {
            Storage::disk($host . '_sub-chapter_uploads')->delete($name);
        }
    }

    public function unlockedPost(Request $request)
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
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $item['time'] . '_' . $item['id'] . '.png';
            Storage::disk($host . '_sub_chapter_uploads_unlocked')->put($imageName, base64_decode($image));

            $img = Image::make('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/unlocked/' . $imageName);
            $img->crop(1242, 2688);
            $imageName = $item['time'] . '_' . $item['id'] . '_3x' . '.png';
            $img->save('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/unlocked/' . $imageName);
            $img->resize(null, 1783, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imageName = $item['time'] . '_' . $item['id'] . '_2x' . '.png';
            $img->save('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/unlocked/' . $imageName);

        }

        return response('success', 200);
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
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $item['time'] . '_' . $item['id'] . '.png';
            Storage::disk($host . '_sub_chapter_uploads_background')->put($imageName, base64_decode($image));

            $img = Image::make('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/background/' . $imageName);
            $img->crop(1242, 2688);
            $imageName = $item['time'] . '_' . $item['id'] . '_3x' . '.png';
            $img->save('/mnt/langlyphpapistorage/' . $host . '/sub-chapter/background/' . $imageName);
            exec("../rusty_image_resize/target/release/rusty_image_resize --input " . '/mnt/langlyphpapistorage/' . $host . '/sub-chapter/background/' . $imageName . " --height 1783 --output " . '/mnt/langlyphpapistorage/' . $host . '/sub-chapter/background/' . $item['time'] . '_' . $item['id'] . '_2x' . " --algorithm lanczos3");
        }

        return response('success', 200);
    }
}
