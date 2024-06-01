<?php

namespace App\Services;

// use App\Models\TwitchAccount;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class TwitchService
{
    public static function getTopGames(array $query): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/games/top?' . Query::build($query);

        $body = self::doGet($endpoint);

        return $body['data'] ?? null;
    }

    public static function getGames(array $query): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/games?' . Query::build($query);

        $body = self::doGet($endpoint);

        return $body['data'] ?? null;
    }

    public static function getClips(array $query): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/clips?' . Query::build($query);

        $body = self::doGet($endpoint);

        if (is_null($body)) return null;

        return [
            'data' => $body['data'],
            'next' => $body['pagination']['cursor'] ?? null
        ];
    }

    public static function getUsers(array $query): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/users?' . Query::build($query);

        $body = self::doGet($endpoint);

        return $body['data'] ?? null;
    }

    public static function getStreamsById(string|array $ids): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/streams?user_id=' . (is_array($ids) ? implode('&user_id=', $ids) : $ids);

        $streams = self::doGet($endpoint);

        return $streams['data'] ?? null;
    }

    // public static function getFollowedChannels(string $login_id): array|null
    // {        
    //     $endpoint = 'https://api.twitch.tv/helix/channels/followed?user_id=' . $login_id;

    //     $client_id = config('services.twitch.client_id');
    //     $access_token = self::refreshingAccessToken($login_id);
    //     $headers = [
    //         'Client-Id' => $client_id,
    //         'Authorization' => 'Bearer ' . $access_token,
    //     ];

    //     $channels = self::doGet($endpoint, $headers);

    //     return $channels['data'] ?? null;
    // }

    public static function searchChannels(array $query): array|null
    {
        $endpoint = 'https://api.twitch.tv/helix/search/channels?' . Query::build($query);

        $channels = self::doGet($endpoint);

        return $channels['data'] ?? null;
    } 


    private static function getAccessToken(): string
    {
        $encrypted_access_token = session()->get('access_token', '');
        if ($encrypted_access_token !== '') {
            return Crypt::decryptString($encrypted_access_token);
        } else {
            $endpoint = 'https://id.twitch.tv/oauth2/token';

            $client_id = config('services.twitch.client_id');
            $client_secret = config('services.twitch.client_secret');

            $form_params = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'grant_type' => 'client_credentials'
            ];

            $token_data = self::doPost($endpoint, [
                'form_params' => $form_params
            ]);
            if (is_null($token_data)) return '';

            $access_token = $token_data['access_token'];
            session()->put('access_token', Crypt::encryptString($access_token));

            return $access_token;
        }
    }

    private static function doPost($endpoint, $body): array|null
    {
        try {
            $client = new Client();
            $response = $client->post($endpoint, $body);
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            $request = $e->getRequest();
            $response = $e->getResponse();
            Log::error('Request URL:' . $request->getUri() . ' HTTP Code:' . $response->getStatusCode() . ' Response:' . $response->getBody());
            return null;
        }
    }

    private static function doGet(string $endpoint, array|null $headers = null): array|null
    {
        $client_id = config('services.twitch.client_id');
        if (is_null($headers)) {
            $access_token = self::getAccessToken();
            $headers = [
                'Client-Id' => $client_id,
                'Authorization' => 'Bearer ' . $access_token
            ];
        }

        try {
            $client = new Client();
            $response = $client->get($endpoint, [
                'headers' => $headers
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
        } catch (ClientException $e) {
            $request = $e->getRequest();
            $response = $e->getResponse();
            Log::error('Request URL:' . $request->getUri() . ' HTTP Code:' . $response->getStatusCode() . ' Response:' . $response->getBody());
            return null;
        }
    }

    // private function refreshingAccessToken(string $login_id): string
    // {
    //     $twitch_account = TwitchAccount::where('login_id', $login_id)->first();

    //     if (self::validateToken($twitch_account->access_token)) return $twitch_account->access_token;

    //     $endpoint = 'https://id.twitch.tv/oauth2/token';

    //     $client_id = config('services.twitch.client_id');
    //     $client_secret = config('services.twitch.client_secret');
    //     $form_params = [
    //         'client_id' => $client_id,
    //         'client_secret' => $client_secret,
    //         'grant_type' => 'refresh_token',
    //         'refresh_token' => $twitch_account->refresh_token,
    //     ];

    //     $headers = [
    //         'Content-Type' => 'application/x-www-form-urlencoded'
    //     ];

    //     $body = [
    //         'headers' => $headers,
    //         'form_params' => $form_params,
    //     ];

    //     $token_data = self::doPost($endpoint, $body);

    //     $expired_at = Carbon::now()->addSeconds($token_data['expires_in']);
    //     $twitch_account->fill([
    //         'access_token' => $token_data['access_token'],
    //         'refresh_token' => $token_data['refresh_token'],
    //         'expired_at' => $expired_at->timestamp
    //     ]);
    //     $twitch_account->save();

    //     return $token_data['access_token'];
    // }

    // private function validateToken(string $access_token): bool
    // {
    //     $endpoint = 'https://id.twitch.tv/oauth2/validate';

    //     $headers = [
    //         'Authorization' => 'OAuth ' . $access_token
    //     ];

    //     $token_status = self::doGet($endpoint, $headers);

    //     return is_null($token_status) ? false : true;
    // }
}