<?php

namespace App\Http\Controllers;

use App\Http\Requests\instanceIdRequest;
use App\Http\Requests\teamCreateRequest;
use App\Models\Instance;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return Team::all();
    }

    public function instanceTeams(instanceIdRequest $request)
    {
        return Instance::find($request->query('instance_id'))->teams;
    }

    public function team($id)
    {
        try {
            return Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json("Team not found.", 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function create(teamCreateRequest $request)
    {
        try {
            $instance = Instance::findOrFail($request['instance_id']);

            $team = Team::create([
                'name' => $request['name'],
                'tag' => $request['tag'],
                'flag' => $request->exists('flag') ? $request['flag'] : null,
                'logo' => $request->exists('logo') ? $request['logo'] : null,
            ]);
            $instance->teams()->attach($team);

            foreach($request['players'] as $playerId) {
                $steam_id = parse_steamid($playerId);
                if($steam_id) {
                    $player = Player::where('steam_id', '=', $steam_id)->first();
                    if ($player) {
                        $team->players()->attach($player);
                    } elseif ($steam_id) {
                        $player = Player::create(['steam_id' => $steam_id]);
                        $team->players()->attach($player);
                    }
                }
            }

        } catch (ModelNotFoundException $e) {
            return response()->json("Instance not found.", 422);
        }

    }

    public function update(teamCreateRequest $request)
    {

    }

    public function destroy($id)
    {
        try {
            $server = Server::findOrFail($id);

            $user_owns = DB::table('server_user')
                    ->where('server_id', '=', $server->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->count() > 0;
            if ($user_owns) {
                $server->delete();
                return response()->json('Server successfully removed', 200);
            } else {
                return response()->json('User does not own this server.', 422);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json("Server not found.", 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }
}
