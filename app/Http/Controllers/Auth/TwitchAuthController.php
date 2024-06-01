<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Favorite;
use App\Models\TwitchAccount;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
// use Usernotnull\Toast\Concerns\WireToast;

class TwitchAuthController extends Controller
{
    // use WireToast;
    /**
     * Redirect the user to the Twitch authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitch')
            ->scopes(['user:read:follows'])
            ->redirect();
    }

    /**
     * Obtain the user information from Twitch.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback()
    {
        try {
            $twitchUser = Socialite::driver('twitch')->user();
            /**
             * id
             * nickname (same as name)
             * name
             * email
             * avatar
             */
            // dd($twitchUser);

            $user = User::firstOrCreate(['email' => $twitchUser->email], [
                'name' => $twitchUser->nickname,
            ]);
            $user->twitch_id = $twitchUser->id;
            $user->save();

            $user_id = $user->id;
            TwitchAccount::firstOrCreate(['user_id' => $user_id], [
                'login_id' => $twitchUser->id,
                'name' => $twitchUser->nickname,
                'email' => $twitchUser->email,
                'avatar' => $twitchUser->avatar,
                'access_token' => $twitchUser->token,
                'refresh_token' => $twitchUser->refreshToken
            ]);

            // Create favorite table
            Favorite::firstOrCreate([
                'user_id' => $user_id,
                'ids' => [],
            ]);
            
            Auth::login($user);
        } catch (InvalidStateException $e) {
            Log::error($e->getMessage());
            // toast()->danger('Failed to log in')->push();
            return back();
        } catch (ClientException $e) {
            Log::error($e->getMessage());
            // toast()->danger('Failed to log in')->push();
            return back();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            // toast()->danger('Failed to log in')->push();
            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // toast()->danger('Failed to log in')->push();
            return back();
        }

        // toast()->success('Log in successfull')->pushOnNextPage();
        return redirect()->route('home');
    }
}