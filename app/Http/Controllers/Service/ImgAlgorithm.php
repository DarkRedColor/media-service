<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;


class ImgAlgorithm extends Controller
{
    public function hostCheck($dbHost)
    {
        $host = 'production';

        if ($dbHost == "127.0.0.1" || $dbHost == "uploads" || Str::contains($dbHost, 'langly-postgresql-stage')) {
            $host = 'uploads';
        }

        return $host;
    }

    public function pngConvertAdventures($image, $host, $itemId, $entity, $locked = true)
    {
        $imageNamePNGL = $itemId . '_L' . '.png';
        $imageNameL = $itemId . '_L' . '.webp';
        $imageNameM = $itemId . '_M' . '.webp';
        $imageNameS = $itemId . '_S' . '.webp';

        if ($locked) {
            $imageNameLockedL = $itemId . '_locked_L' . '.webp';
            $imageNameLockedM = $itemId . '_locked_M' . '.webp';
            $imageNameLockedS = $itemId . '_locked_S' . '.webp';
        }

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);


            Storage::disk($host . '_' . $entity . '_uploads')->put($imageNamePNGL, base64_decode($image));





        $image = Image::make('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNamePNGL);
        (string)$image->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameL, 94, 'webp');
        $image = Image::make('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameL);
        if ($locked) {
            $image->backup();

            $image->greyscale()->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameLockedL, 100);
            $imageLocked = Image::make('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameLockedL);

        $image->reset();
        }
        $imgHeightInit = $image->height();
        $imgHeight = round($imgHeightInit * 2 / 3, 0, PHP_ROUND_HALF_UP);

        $image->resize(null, $imgHeight, function ($constraint) {
            $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
        })->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameM);

        $imgHeight = round($imgHeightInit / 3, 0, PHP_ROUND_HALF_UP);

        $image->resize(null, $imgHeight, function ($constraint) {
            $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
        })->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameS);

        if ($locked) {
            $imgLockedHeightInit = $imageLocked->height();
            $imgLockedHeight = round($imgLockedHeightInit * 2 / 3, 0, PHP_ROUND_HALF_UP);

            $imageLocked->resize(null, $imgLockedHeight, function ($constraint) {
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameLockedM);

            $imgLockedHeight = round($imgLockedHeightInit / 3, 0, PHP_ROUND_HALF_UP);

            $imageLocked->resize(null, $imgLockedHeight, function ($constraint) {
                $constraint->aspectRatio();
//                $constraint->upsize(); // prevent possible upsizing
            })->save('/mnt/langlyphpapistorage/' . $host . "/$entity/" . $imageNameLockedS);
        }
    }
}
