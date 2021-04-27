<?php

namespace App\Http\Controllers;

use App\Http\Requests\rconRequest;
use App\Http\Requests\srcdsServerCreateRequest;
use App\Http\Requests\srcdsServerDestroyRequest;
use App\Http\Requests\srcdsServerUpdateRequest;
use App\Models\Server;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class srcdsModelController extends srcdsController
{
    public function index()
    {
        return Server::with('users')->get();
    }

    public function userServers(Request $request)
    {
        return $request->user()->servers;
    }

    public function server($id)
    {
        try {
            $server = Server::findOrFail($id);

            $user_owns = DB::table('server_user')
                    ->where('server_id', '=', $server->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->count() > 0;
            if ($user_owns) {
                return $server;
            } else {
                return response()->json('User does not own this server.', 422);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json("Server not found.", 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function create(srcdsServerCreateRequest $request)
    {
        $toRcon = rconRequest::createFrom($request);
        if (!Server::where('server_ip', '=', $request['address'])->where('server_port', '=', $request['port'])->first()) {
            $get5check = $this->checkAvailability($toRcon);
            if ($get5check->status() === 200) {
                $user = $request->user();
                $server = Server::create([
                    'name' => $request['name'],
                    'server_ip' => $request['address'],
                    'server_port' => $request['port'],
                    'gotv_port' => $request['gotv_port'],
                    'password' => $request['password'],
                ]);
                $server->users()->save($user);
                return $server;
            } else {
                return response()->json("Could not connect to the server. " . $get5check->original, 422);
            }
        } else {
            return response()->json("Server is already registered.", 422);
        }
    }
    public function update(srcdsServerUpdateRequest $request)
    {
        $toRcon = rconRequest::createFrom($request);
        if ($server = Server::findOrFail($request['id'])) {
            $user_owns = DB::table('server_user')
                    ->where('server_id', '=', $server->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->count() > 0;
            if ($user_owns) {

                $get5check = $this->checkAvailability($toRcon);
                if ($get5check->status() === 200) {
                    $server->update([
                        'name' => $request['name'],
                        'server_ip' => $request['address'],
                        'server_port' => $request['port'],
                        'gotv_port' => $request['gotv_port'],
                        'password' => $request['password'],
                    ]);
                    return $server;
                } else {
                    return response()->json("Could not connect to the server. " . $get5check->original, 422);
                }
            } else {
                return response()->json("Server does not belong to you.", 422);
            }
        } else {
            return response()->json("Server not found.", 422);
        }
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
