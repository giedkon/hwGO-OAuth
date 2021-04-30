<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['steam_id'];

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function getSteamInfoAttribute()
    {
        $client = new Client();

        $response = $client->get('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key='
            .config('services.steam_api.key')
            .'&steamids='
            .$this->steam_id);
        return json_decode($response->getBody()->getContents())->response->players[0];
    }

    public function getBanInfoAttribute()
    {
        $client = new Client();

        $response = $client->get('https://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key='
            .config('services.steam_api.key')
            .'&steamids='
            .$this->steam_id);
        return json_decode($response->getBody()->getContents())->players[0];
    }
    public function getCsgoInfoAttribute()
    {
        $client = new Client();

        $response = $client->get('https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v2/?key='
            .config('services.steam_api.key')
            .'&steamid='
            .$this->steam_id.
            '&appid=730');
        return json_decode($response->getBody()->getContents());
    }
}
