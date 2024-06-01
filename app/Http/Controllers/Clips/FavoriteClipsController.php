<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\TwitchService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Number;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteClipsController extends Controller
{
    public function index():View
    {
        $authUserId = Auth::id();
        $favoriteClipIds = Favorite::where('user_id', $authUserId)->first()['ids'];

        $favoriteClips = [];
        foreach (array_chunk($favoriteClipIds, 100) as $ids) {
            $clipsBody = TwitchService::getClips(['id' => $ids]);
            if (is_null($clipsBody) || count($clipsBody['data']) === 0) return view('favorite.index');
            
            $clips = $clipsBody['data'];
            $broadcasterIds = array_column($clips, 'broadcaster_id');
            $users = TwitchService::getUsers([
                'id' => $broadcasterIds
            ]);
            if (is_null($users) || count($users) === 0) continue;

            $userIds = array_column($users, 'id');
            foreach ($clips as $clipIdx => &$clip) {
                $key = array_search($clip['broadcaster_id'], $userIds);
                if ($key !== false) {
                    $clip['view_count'] = Number::abbreviate($clip['view_count']);
                    $clip['created_at'] = CarbonImmutable::parse($clip['created_at'])->format('Y/m/d H:i');
                    $clip['channel_id'] = $users[$key]['login'];
                    $clip['avatar'] = $users[$key]['profile_image_url'];
                } else {
                    unset($clips[$clipIdx]);
                }
            }
            $favoriteClips = array_merge($favoriteClips, $clips);
        }

        return view('favorite.index')->with(['clips' => $favoriteClips]);
    }

    public function save(Request $request): RedirectResponse
    {
        $saveClipId = $request->clip_id;
        if (is_null($saveClipId)) return back();

        $authUserId = Auth::id();
        $favoriteTable = Favorite::where('user_id', $authUserId)->first();

        $favoriteIds = $favoriteTable['ids'];
        if (in_array($saveClipId, $favoriteIds)) {
            return back();
        }

        array_push($favoriteIds, $saveClipId);
        $favoriteTable->fill([
            'ids' => $favoriteIds
        ]);
        $favoriteTable->save();

        return back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $deleteClipId = $request->clip_id;
        if (is_null($deleteClipId)) return back();

        $authUserId = Auth::id();
        $favoriteTable = Favorite::where('user_id', $authUserId)->first();

        $favoriteIds = $favoriteTable['ids'];
        $key = array_search($deleteClipId, $favoriteIds);
        if ($key !== false) {
            unset($favoriteIds[$key]);
        }

        $favoriteTable->fill([
            'ids' => $favoriteIds
        ]);
        $favoriteTable->save();

        return back();
    }
}
