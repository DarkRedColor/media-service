<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

//---------------------------------------------------- Only For Developer --------------------------------------------------//

        'uploads_lang_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/language/icon',
        ],
        'uploads_season_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/season',
        ],
        'uploads_animation_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/animation',
        ],
        'uploads_file/text_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/file/text',
        ],

        'uploads_file/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/file/audio',
        ],
        'uploads_file/video_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/file/video',
        ],
        'uploads_word_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/word',
        ],

        'uploads_word/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/word/audio',
        ],
        'uploads_game/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/game/audio',
        ],

        'uploads_theory_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/theory',
        ],
        'uploads_episode_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/episode',
        ],
        'uploads_episode/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/episode/additional',
        ],
        'uploads_chapter/image_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/chapter/image',
        ],
        'uploads_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/chapter/background',
        ],
        'uploads_sub_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/sub-chapter/background',
        ],
        'uploads_sub-chapter_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/sub-chapter',
        ],
        'uploads_game_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/game',
        ],
        'uploads_game/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/game/additional',
        ],
        'uploads_sub_chapter_uploads_unlocked' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/sub-chapter/unlocked',
        ],
        'uploads_dialogue_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/personage',
        ],
        'uploads_emotion_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/emotion',
        ],
        'uploads_bg_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/uploads/bg',
        ],


        //---------------------------------------------------- For Production server --------------------------------------------------//


        'production_lang_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/language/icon',
        ],
        'production_season_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/season',
        ],
        'production_file/text_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/file/text',
        ],
        'production_file/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/file/audio',
        ],
        'production_word/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/word/audio',
        ],
        'production_game/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/game/audio',
        ],
        'production_file/video_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/file/video',
        ],
        'production_word_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/word',
        ],
        'production_theory_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/theory',
        ],
        'production_episode_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/episode',
        ],
        'production_episode/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/episode/additional',
        ],
        'production_chapter/image_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/chapter/image',
        ],
        'production_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/chapter/background',
        ],
        'production_sub_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/sub-chapter/background',
        ],
        'production_sub-chapter_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/sub-chapter',
        ],
        'production_sub_chapter_uploads_unlocked' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/sub-chapter/unlocked',
        ],
        'production_dialogue_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/personage',
        ],
        'production_emotion_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/emotion',
        ],
        'production_bg_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/bg',
        ],
        'production_game_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/game',
        ],
        'production_game/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/production/game/additional',
        ],


        //---------------------------------------------------- For Development Server --------------------------------------------------//


        'development_lang_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/language/icon',
        ],
        'development_season_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/season',
        ],
        'development_file/text_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/file/text',
        ],

        'development_file/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/file/audio',
        ],
        'development_word/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/word/audio',
        ],
        'development_game/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/game/audio',
        ],
        'development_file/video_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/file/video',
        ],
        'development_word_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/word',
        ],
        'development_theory_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/theory',
        ],
        'development_episode_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/episode',
        ],
        'development_episode/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/episode/additional',
        ],
        'development_chapter/image_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/chapter/image',
        ],
        'development_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/chapter/background',
        ],
        'development_sub_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/sub-chapter/background',
        ],
        'development_sub-chapter_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/sub-chapter',
        ],
        'development_sub_chapter_uploads_unlocked' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/sub-chapter/unlocked',
        ],
        'development_dialogue_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/personage',
        ],
        'development_emotion_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/emotion',
        ],
        'development_bg_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/bg',
        ],
        'development_game_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/game',
        ],
        'development_game/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/development/game/additional',
        ],


        //---------------------------------------------------- For Trash Server --------------------------------------------------//


        'trash_lang_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/language/icon',
        ],
        'trash_season_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/season',
        ],
        'trash_file/text_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/file/text',
        ],
        'trash_file/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/file/audio',
        ],
        'trash_word/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/word/audio',
        ],
        'trash_game/audio_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/game/audio',
        ],
        'trash_file/video_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/file/video',
        ],
        'trash_word_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/word',
        ],
        'trash_theory_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/theory',
        ],
        'trash_episode_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/episode',
        ],
        'trash_episode/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/episode/additional',
        ],
        'trash_chapter/image_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/chapter/image',
        ],
        'trash_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/chapter/background',
        ],
        'trash_sub_chapter_uploads_background' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/sub-chapter/background',
        ],
        'trash_sub-chapter_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/sub-chapter',
        ],
        'trash_sub_chapter_uploads_unlocked' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/sub-chapter/unlocked',
        ],
        'trash_dialogue_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/personage',
        ],
        'trash_emotion_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/emotion',
        ],
        'trash_bg_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/bg',
        ],
        'trash_game_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/game',
        ],
        'trash_game/additional_uploads' => [
            'driver' => 'local',
            'root' => '/mnt/langlyphpapistorage/trash/game/additional',
        ],


        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
