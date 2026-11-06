# Media Service

A Laravel microservice that receives, processes, stores and serves the media files (images, audio and video) for a game-based English-learning platform. It sits next to the main backend ([language-learning-backend](https://github.com/DarkRedColor/language-learning-backend)): the admin panel uploads media here, and the mobile app downloads ready-to-use files from here.

I wrote this service while working as a backend developer at Langly (2022–2023). The company has since closed; the code is published as a portfolio project.

## How it fits together

```
Admin panel (main backend)
        │  POST base64 image / audio + entity id
        ▼
  Media Service  ── converts, resizes, stores ──►  shared storage volume
        ▲                                         /mnt/<storage>/<slot>/<entity>/
        │  GET /{entity}/{slot}/{id}
   Mobile app
```

- **slot** (`host` in the routes) separates environments on the same storage: `uploads` for development/stage, `production` for live content. It is chosen from the caller's database host in `ImgAlgorithm::hostCheck()`.
- Each content type (season, episode, chapter, sub-chapter, word, theory, game, background, emotion, language icon, text/audio/video files) has its own storage disk in `config/filesystems.php`.

## Image pipeline

`app/Http/Controllers/Service/ImgAlgorithm.php`, built on Intervention Image (GD):

1. Accept a base64-encoded PNG and store the original.
2. Convert to **WebP** (quality 94).
3. Generate three sizes for different screen densities: **L** (original), **M** (2/3 height), **S** (1/3 height), keeping the aspect ratio.
4. For lockable content (chapters, episodes, games…) also generate **greyscale "locked"** versions in all three sizes.
5. Remove the temporary PNG.

Audio (word pronunciation, game audio) and video files are stored and served as-is.

## API overview

| Method | Route | Purpose |
| --- | --- | --- |
| `POST` | `/api/{entity}` | upload one or more files (JSON array of `{id, file, format, host}`) |
| `GET` | `/api/{entity}/{host}/{id}` | download a processed file |
| `POST` | `/api/{entity}/delete/{id}/{host}` | delete all generated variants |

Entities: `season`, `episode`, `episode/additional`, `chapter/image`, `chapter/background`, `sub-chapter/image`, `sub-chapter/background`, `emotion`, `bg`, `word`, `word/audio`, `theory`, `game`, `language`, `file/text`, `file/audio`, `file/video`, `quiz`. See `routes/api.php` for the full list.

## Tech stack

- PHP 8 / Laravel 8
- Intervention Image (GD) for conversion and resizing, `spatie/laravel-image-optimizer`
- Laravel Sail Docker runtimes (`docker/`)

## Running locally

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan serve
```

The storage disks expect a mounted volume (see `config/filesystems.php`); point the `root` paths at a local folder for development.

## Notes

- A few endpoints (chapter and sub-chapter backgrounds, personages) call an external high-quality resize binary that was written by a colleague and is **not included** in this repository; the rest of the pipeline is pure PHP.
- What I would improve today: move the hard-coded storage paths into configuration, validate uploads with Form Requests instead of manual checks, and replace the repeated per-entity controllers with one generic media controller driven by configuration.
