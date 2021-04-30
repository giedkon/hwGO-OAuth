<?php

use chx2\SteamID;
use GuzzleHttp\Client;

if (!function_exists('parse_steamid')) {
    function parse_steamid($String) {
        // Check if string is URL, if yes, return last part
        if($String) {
            if (preg_match('/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/', $String)) {
                $String = basename($String);
            }

            // Create chx2\SteamID Object for checks
            $id = new SteamID($String, config('services.steam_api.key'));
            if ($id->isID64() || $id->isID32()) {
                return $id->toCommunityID();
            } else {
                // If it's a vanity URL, decode it and return steamID64, or return that it could not be processed
                $client = new Client();

                $response = $client->get('https://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/', [
                    'query' => [
                        'key' => config('services.steam_api.key'),
                        'vanityurl' => $String,
                        'url_type' => 1
                    ]
                ]);
                $response = json_decode($response->getBody()->getContents())->response;
                if ($response->success === 1) {
                    return $response->steamid;
                } else {
                    return null;
                }
            }
        }
    }
}
