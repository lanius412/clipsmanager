<?php

namespace App\Traits;

use App\Services\TwitchService;

trait ClipTrait
{
    public static function repeatGetClips(array $query, int|null $maxResults = null): array
    {
        $clips = [];

        $next = null;
        do {

            $clips_body = TwitchService::getClips($query);
            if (is_null($clips_body) || count($clips_body['data']) === 0) break;

            $clips = array_merge($clips, $clips_body['data']);
            if (!is_null($maxResults) && count($clips) > $maxResults) {
                return array_slice($clips, 0, $maxResults);
            }

            $next = $clips_body['next'];

            $query['after'] = $next;
        } while (!is_null($next));

        return $clips;
    }
}