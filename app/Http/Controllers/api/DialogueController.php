<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ImgAlgorithm;
use App\Http\Controllers\Service\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DialogueController extends Controller
{
    public function persGet($host, $id)
    {
        $png = '/mnt/langlyphpapistorage/' . $host . '/personage/' . $id;
        if (file_exists($png)) {
            return response()->download($png);
        } else {
            return response("file not found", 400);
        }
    }

    public function emoGet($host, $id)
    {
        $png = glob('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $id . ".*");

        $response = new Response();

        return $response->responseImgOrFail($png);

    }

    public function persPost(Request $request)
    {
        $files = $request->all();
        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $item) {
            if (!array_key_exists('file', $item) || $item['file'] == null) {
                return response('no file or wrong array key', 400);
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
            if ($item['format'] == "data:image/png;base64,") {
                $image = str_replace('data:image/png;base64,', '', $image);
                $format = '.png';
                $imageName = $item['time'] . '_3x' . '.png';
            } elseif ($item['format'] == "data:image/jpeg;base64,") {
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $format = '.jpeg';
                $imageName = $item['time'] . '_3x' . '.jpeg';
            } elseif ($item['format'] == "data:image/jpg;base64,") {
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $format = '.jpg';
                $imageName = $item['time'] . '_3x' . '.jpg';
            }

            $image = str_replace(' ', '+', $image);
            $disk = Storage::disk($host . '_dialogue_uploads');
            $disk->put($imageName, base64_decode($image, true));

            $img = Image::make('/mnt/langlyphpapistorage/' . $host . '/personage/' . $imageName)->height();
            $img = round($img * 2 / 3, 0, PHP_ROUND_HALF_UP);

            exec("../rusty_image_resize/target/release/rusty_image_resize --input " . '/mnt/langlyphpapistorage/' . $host . '/personage/' . $imageName . " --height " . $img . " --output " . '/mnt/langlyphpapistorage/' . $host . '/personage/' . $item['time'] . '_2x' . $format . " --algorithm lanczos3");
        }

        return response("success", 200);
    }

    public function emoPost(Request $request)
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
                Storage::disk($host . '_emotion_uploads')->put($imageNamePNGL, base64_decode($image));
                $image = Image::make('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $imageNamePNGL);
                (string)$image->save('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $imageNameL, 94, 'webp');
                $image = Image::make('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $imageNameL);
                $imageNameM = $item['id'] . '_M' . '.webp';
                $imageNameS = $item['id'] . '_S' . '.webp';
            } else {
                return response('bad format', 400);
            }
            $imgHeight = $image->height();
            $image->resize(null, $imgHeight * 2 / 3, function ($constraint) {
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $imageNameM);

            $image->resize(null, $imgHeight / 3, function ($constraint) {
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . '/emotion/' . $imageNameS);

            $this->deletePng($imageNamePNGL, $host);

        }

        return response('done', 200);


    }

    public function delPng($id, $host)
    {
        $this->deletePng($id . '_L.webp', $host);
        $this->deletePng($id . '_M.webp', $host);
        $this->deletePng($id . '_S.webp', $host);
    }

    public function delPersonageEmotions(Request $request, $host)
    {
        if (isset($request->arr) && !empty($request->arr)) {
            foreach ($request->arr as $item) {
                $this->deletePng($item . '_L.webp', $host);
                $this->deletePng($item . '_M.webp', $host);
                $this->deletePng($item . '_S.webp', $host);
            }
            return response('done', 200);
        } else {
            return response('oops, something is going wrong', 400);
        }

    }

    private function deletePng($name, $host)
    {
        if (Storage::disk($host . '_emotion_uploads')->exists($name)) {
            Storage::disk($host . '_emotion_uploads')->delete($name);
        }
    }

}
