<?php

namespace App\Http\Controllers;

use App\Http\Requests\rconRequest;
use Illuminate\Http\Request;
use xPaw\SourceQuery\SourceQuery;

class srcdsController extends Controller
{

    protected $engine;
    protected $rcon;
    /**
     * srcdsController constructor.
     * @param int $engine
     */
    public function __construct()
    {
        $this->engine = SourceQuery::SOURCE;
        $this->rcon = new SourceQuery();
    }

    public function pingServer(rconRequest $request)
    {
        try {
            $this->rcon->Connect($request['address'], $request['port'], 3, $this->engine);
            $this->rcon->SetRconPassword($request['password']);
            return response()->json(parse_hlds_status($this->rcon->Rcon('status'), 200));
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        } finally {
            $this->rcon->Disconnect();
        }
    }

    public function checkAvailability(rconRequest $request)
    {
        try {
            $this->rcon->Connect($request['address'], $request['port'], 3, $this->engine);
            $this->rcon->SetRconPassword($request['password']);
            return response()->json(rcon_json_parse($this->rcon->Rcon('get5_web_avaliable')), 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        } finally {
            $this->rcon->Disconnect();
        }
    }
}

