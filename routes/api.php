<?php

use App\Http\Controllers\api\BackgroundController;
use App\Http\Controllers\api\ChapterController;
use App\Http\Controllers\api\DialogueController;
use App\Http\Controllers\api\EpisodeController;
use App\Http\Controllers\api\FileController;
use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\LanguageController;
use App\Http\Controllers\api\QuizController;
use App\Http\Controllers\api\SeasonController;
use App\Http\Controllers\api\SubChapterController;
use App\Http\Controllers\api\TheoryController;
use App\Http\Controllers\api\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Season

Route::prefix('season')->group(function () {
    Route::post('/', [SeasonController::class, 'imgPost']);
    Route::post('/delete/{id}/{host}', [SeasonController::class, 'delPng']);
    Route::get('/{host}/{id}', [SeasonController::class, 'imgGet']);
});

//file

Route::prefix('file')->group(function () {
    Route::prefix('text')->group(function () {
        Route::post('/', [FileController::class, 'imgPost']);
        Route::post('/delete/{id}/{host}', [FileController::class, 'delPng']);
        Route::get('/{host}/{id}', [FileController::class, 'imgGet']);
    });
    Route::prefix('audio')->group(function () {
        Route::post('/', [FileController::class, 'audioPost']);
        Route::post('/delete/{id}/{host}', [FileController::class, 'delAudio']);
        Route::get('/{host}/{id}', [FileController::class, 'audioGet']);
    });
    Route::prefix('video')->group(function () {
        Route::post('/delete/{id}/{host}', [FileController::class, 'delVideo']);
        Route::get('/{host}/{id}', [FileController::class, 'videoGet']);
    });
});

Route::prefix('quiz')->group(function () {
    Route::get('/{host}/{id}', [QuizController::class, 'imgGet']);
});

//Language

Route::prefix('language')->group(function () {
    Route::post('/', [LanguageController::class, 'icoPost']);
    Route::get('/{host}/{iso}', [LanguageController::class, 'icoGet']);
});

//Episode

Route::prefix('episode')->group(function () {
    Route::get('/{host}/{id}', [EpisodeController::class, 'imageGet']);
    Route::post('/', [EpisodeController::class, 'imagePost']);
    Route::post('/delete/{id}/{host}', [EpisodeController::class, 'delPng']);

    Route::prefix('additional')->group(function () {
        Route::get('/{host}/{id}', [EpisodeController::class, 'imageAdditionalGet']);
        Route::post('/', [EpisodeController::class, 'imageAdditionalPost']);
        Route::post('/delete/{id}/{host}', [EpisodeController::class, 'delAdditionalPng']);
    });
});

//Chapter

Route::prefix('chapter')->group(function () {
    Route::post('/image', [ChapterController::class, 'imgPost']);
    Route::post('/background', [ChapterController::class, 'backgroundPost']);
    Route::get('/image/{host}/{id}', [ChapterController::class, 'imgGet']);
    Route::get('/background/{host}/{id}', [ChapterController::class, 'backgroundGet']);
    Route::post('/image/delete/{id}/{host}', [ChapterController::class, 'delPng']);
});

//SubChapter

Route::prefix('sub-chapter')->group(function () {
    Route::post('/image', [SubChapterController::class, 'lockedPost']);
    Route::post('/background', [SubChapterController::class, 'backgroundPost']);
//Route::post('/unlocked', [SubChapterController::class, 'unlockedPost']);
    Route::get('/image/{host}/{id}', [SubChapterController::class, 'lockedGet']);
    Route::get('/background/{host}/{id}', [SubChapterController::class, 'backgroundGet']);
//Route::get('/unlocked/{host}/{id}', [SubChapterController::class, 'unlockedGet']);
    Route::post('/image/delete/{id}/{host}', [SubChapterController::class, 'delPng']);
});

//Dialogue

Route::prefix('emotion')->group(function () {
//Route::post('/dialogue/image', [DialogueController::class, 'persPost']);
    Route::post('/', [DialogueController::class, 'emoPost']);
    Route::post('/delete/{id}/{host}', [DialogueController::class, 'delPng']);
    Route::get('/{host}/{id}', [DialogueController::class, 'emoGet']);
});

Route::post('/personage/delete/{host}', [DialogueController::class, 'delPersonageEmotions']);

//Background

Route::prefix('bg')->group(function () {
    Route::post('/', [BackgroundController::class, 'postBg']);
    Route::get('/{host}/{id}', [BackgroundController::class, 'backgroundGet']);
    Route::post('/delete/{id}/{host}', [BackgroundController::class, 'delPng']);
});

//Word

Route::prefix('word')->group(function () {
    Route::post('/', [WordController::class, 'imgPost']);
    Route::post('/delete/{id}/{host}', [WordController::class, 'delPng']);
    Route::get('/{host}/{id}', [WordController::class, 'imgGet']);

    Route::prefix('audio')->group(function () {
        Route::post('/', [WordController::class, 'audioPost']);
        Route::post('/delete/{id}/{host}', [WordController::class, 'delAudio']);
        Route::get('/{host}/{id}', [WordController::class, 'audioGet']);
    });
});

//Theory

Route::prefix('theory')->group(function () {
    Route::post('/', [TheoryController::class, 'imgPost']);
    Route::post('/delete/{id}/{host}', [TheoryController::class, 'delPng']);
    Route::get('/{host}/{id}', [TheoryController::class, 'imgGet']);
});

//Game

Route::prefix('game')->group(function () {
    Route::get('/{host}/{id}', [GameController::class, 'imageGet']);
    Route::post('/', [GameController::class, 'imagePost']);
    Route::post('/delete/{id}/{host}', [GameController::class, 'delPng']);

    Route::prefix('audio')->group(function () {
        Route::post('/', [GameController::class, 'audioPost']);
        Route::post('/delete/{id}/{host}', [GameController::class, 'delAudio']);
        Route::get('/{host}/{id}', [GameController::class, 'audioGet']);
    });

    Route::prefix('additional')->group(function () {
        Route::get('/{host}/{id}', [GameController::class, 'imageAdditionalGet']);
        Route::post('/', [GameController::class, 'imageAdditionalPost']);
        Route::post('/delete/{id}/{host}', [GameController::class, 'delAdditionalPng']);
    });
});

Route::get('/archive/test', [BackgroundController::class, 'archiveTest']);


