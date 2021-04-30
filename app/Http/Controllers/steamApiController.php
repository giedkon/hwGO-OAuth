<?php

namespace App\Http\Controllers;

use App\Http\Requests\steamIdRequest;
use App\Models\Player;
use http\Env\Response;
use Illuminate\Http\Request;

class steamApiController extends Controller
{
    public function getUserInfoBySteamID(){
        $steam_id = parse_steamid(request()->query('steam_id'));
        $player = Player::where('steam_id', '=', $steam_id)->first();
        if($player) {
            return response()->json($player->SteamInfo);
        } elseif ($steam_id) {
            $player = Player::create(['steam_id' => $steam_id]);
            return response()->json($player->SteamInfo);
        } else {
            return response()->json("SteamID invalid or incorrect format.", 422);
        }
    }
    public function getUserBanInfoBySteamID(){
        $steam_id = parse_steamid(request()->query('steam_id'));
        $player = Player::where('steam_id', '=', $steam_id)->first();
        if($player) {
            return response()->json($player->BanInfo);
        } elseif ($steam_id) {
            $player = Player::create(['steam_id' => $steam_id]);
            return response()->json($player->BanInfo);
        } else {
            return response()->json("SteamID invalid or incorrect format.", 422);
        }
    }
    public function getUserCsgoInfoBySteamID(){
        $steam_id = parse_steamid(request()->query('steam_id'));
        $player = Player::where('steam_id', '=', $steam_id)->first();
        if($player) {
            return response()->json($player->CsgoInfo);
        } elseif ($steam_id) {
            $player = Player::create(['steam_id' => $steam_id]);
            return response()->json($player->CsgoInfo);
        } else {
            return response()->json("SteamID invalid or incorrect format.", 422);
        }
    }
}
