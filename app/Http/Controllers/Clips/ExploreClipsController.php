<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Services\TwitchService;
use App\Traits\ClipTrait;
use Carbon\CarbonImmutable;
use Illuminate\Support\Number;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExploreClipsController extends Controller
{
    use ClipTrait;

    public function exploreClips (Request $request): View|RedirectResponse
    {   
        // Load from session
        $params = $request->all();
        if ($params === json_decode(session()->get('explore_params', ''), true)) {
            if (session()->has('clips')) {
                $sessionClips = json_decode(session()->get('clips', ''), true);
                return view('explore.results.index')->with(['clips' => $sessionClips]);
            }
            // return view('explore.results.index');
        }

        $loginId = $request->channel_id;
        $gameId = $request->game_id;
        $keyword = $request->keyword;
        $minViewCount = $request->min_view_count;
        $startedAt = $request->start_date;
        $endedAt = $request->end_date;

        // Validate
        if (is_null($loginId) && is_null($gameId)) {
            return back();
        }

        // Set query
        $query = ['first' => 100];
        if (is_null($startedAt) && is_null($endedAt)) {
            $now = CarbonImmutable::now();
            $query['started_at'] = $now->subWeek()->toRfc3339String();
            $query['ended_at'] = $now->toRfc3339String();
        } else if (is_null($startedAt)) {
            $dtEndedAt = CarbonImmutable::parse($endedAt);
            $query['started_at'] = $dtEndedAt->subWeek()->toRfc3339String();
            $query['ended_at'] = $dtEndedAt->toRfc3339String();
        } else if (is_null($endedAt)) {
            $dtStartedAt = CarbonImmutable::parse($startedAt);
            $query['started_at'] = $dtStartedAt->toRfc3339String();
            $query['ended_at'] = $dtStartedAt->addWeek()->toRfc3339String();
        } else {
            $query['started_at'] = CarbonImmutable::parse($startedAt)->toRfc3339String();
            $query['ended_at'] = CarbonImmutable::parse($endedAt)->toRfc3339String();
        }

        // Get clips
        if (!is_null($loginId)) {
            $users = TwitchService::getUsers(['login' => $loginId]);
            if (is_null($users) || count($users) === 0) {
                session()->forget('clips');
                return view('explore.results.index');
            }
            $query['broadcaster_id'] = $users[0]['id'];

            $clips = static::repeatGetClips($query, 200);
            if (count($clips) === 0) {
                session()->forget('clips');
                return view('explore.results.index');
            }

            // Filter clips
            self::filterByTitle($clips, $keyword);
            self::filterByViewCount($clips, $minViewCount);

            // Add data
            foreach ($clips as &$clip) {
                $clip['view_count'] = Number::abbreviate($clip['view_count']);
                $clip['created_at'] = CarbonImmutable::parse($clip['created_at'])->format('Y/m/d H:i');
                $clip['channel_id'] = $loginId;
                $clip['avatar'] = $users[0]['profile_image_url'];
            }
        } else {
            $query['game_id'] = $gameId;

            $clips = static::repeatGetClips($query, 200);
            if (count($clips) === 0) {
                session()->forget('clips');
                return view('explore.results.index');
            }
            // Filter clips
            self::filterByTitle($clips, $keyword);
            self::filterByViewCount($clips, $minViewCount);

            if (count($clips) === 0) {
                session()->forget('clips');
                return view('explore.results.index');
            }

            // Add data
            foreach (array_chunk($clips, 100) as $chunkIdx => $chunkedClips) {
                $broadcasterIds = array_column($chunkedClips, 'broadcaster_id');
                $users = TwitchService::getUsers(['id' => $broadcasterIds]);
                if (is_null($users) || count($users) === 0) {
                    continue;
                }
                for ($i = 0; $i < count($chunkedClips); $i++) {
                    $clipIdx = $chunkIdx * 100 + $i;
                    
                    $isMatched = false;
                    foreach ($users as $user) {
                        if ($clips[$clipIdx]['broadcaster_id'] === $user['id']) {
                            $clips[$clipIdx]['view_count'] = Number::abbreviate($clips[$clipIdx]['view_count']);
                            $clips[$clipIdx]['created_at'] = CarbonImmutable::parse($clips[$clipIdx]['created_at'])->format('Y/m/d H:i');
                            $clips[$clipIdx]['channel_id'] = $user['login'];
                            $clips[$clipIdx]['avatar'] = $user['profile_image_url'];
                            $isMatched = true;
                            break;
                        }
                    }
                    if (!$isMatched) {
                        unset($clips[$clipIdx]);
                    }
                }
            }
        }

        session()->put('explore_params', json_encode($params));
        session()->put('clips', json_encode($clips));

        return view('explore.results.index')->with(['clips' => $clips]);
    }

    private static function filterByTitle(array &$clips, string|null $keyword = null): void
    {
        if (is_null($keyword)) return;

        foreach ($clips as $idx => $clip) {
            if (!str_contains($clip['title'], $keyword)) {
                unset($clips[$idx]);
            }
        }
    }

    private static function filterByViewCount(array &$clips, string $minViewCount): void
    {
        $minViewCount = ctype_digit($minViewCount) ? (int)$minViewCount : 30;

        foreach($clips as $idx => $clip) {
            if ($minViewCount > $clip['view_count']) {
                unset($clips[$idx]);
            }
        }
    }
}
