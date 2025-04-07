<?php

namespace App\Helpers;

use App\Models\Video;

class DefaultVideoHelper
{
    public static function createDefaultVideos(): void
    {
        Video::query()->firstOrCreate([
            'title' => 'Video 1 - Run - BTS',
            'description' => 'Video de la canción Run de BTS.',
            'url' => 'https://www.youtube.com/watch?v=wKysONrSmew',
            'published_at' => now(),
        ]);

        Video::query()->firstOrCreate([
            'title' => 'Video 2 - Mic Drop - BTS',
            'description' => 'Video de la canción Mic Drop de BTS.',
            'url' => 'https://www.youtube.com/watch?v=kTlv5_Bs8aw',
            'published_at' => now(),
        ]);

        Video::query()->firstOrCreate([
            'title' => 'Video 3 - Butterfly - BTS',
            'description' => 'Video de la canción Butterfly de BTS.',
            'url' => 'https://www.youtube.com/watch?v=Xy9heqcKLAI',
            'published_at' => now(),
        ]);
    }
}
