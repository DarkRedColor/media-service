<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class LanguageController extends Controller
{
    public function icoGet($host ,$iso)
    {
        $png = '/mnt/langlyphpapistorage/'.$host .'/language/icon/' . $iso . '.png';
        if (file_exists($png)) {
            return response()->download($png);
        } else {
            return response("file not found", 400);
        }
    }

    public function icoPost(Request $request)
    {
        $files = $request->all();

        if (count($files) == 0) {
            return response('no content', 400);
        }
        foreach ($files as $item) {
            if (!array_key_exists('file', $item) || $item['file'] == null) {
                return response('no file or wrong array key', 400);
            }
            if (!array_key_exists('iso', $item) || $item['iso'] == null) {
                return response('no iso or wrong array key', 400);
            }
            $dbHost = $item['host'];

            $host = 'uploads';

            if (Str::contains($dbHost, 'langly-postgresql-development') || Str::contains($dbHost, 'langly-postgresql-stage') || Str::contains($dbHost, 'langly-postgresql-release') || Str::contains($dbHost, 'langly-postgresql-production')) {
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
            $imageName = $item['iso'] . '.png';
            Storage::disk(  $host . '_lang_uploads')->put($imageName, base64_decode($image));
        }

        return response('success', 200);
    }
}
