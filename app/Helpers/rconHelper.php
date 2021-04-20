<?php
if (!function_exists('parse_hlds_status')) {
    function rcon_json_parse($String)
    {
        $end = strrpos($String, '}');

        $cut = substr($String, 0, $end + 1);
        $decoded = json_decode($cut);

        return $decoded;
    }

    function parse_hlds_status($StatusString): array
    {
        /*
        *	Parse server parameters
        */


        $params[0] = array("name" => 'hostname', "pattern" => "^hostname\s*:\s*(.*)$");
        $params[1] = array("name" => 'version', "pattern" => "version\s*:\s*(.*)$");
        $params[2] = array("name" => 'udp/ip', "pattern" => "udp\/ip\s*:\s*(.*)");
        $params[3] = array("name" => 'map', "pattern" => "map\s*:\s*([\w-]+).*$");
        $params[4] = array("name" => 'maxplayers', "pattern" => "players\s*:\s*(\d+).*\((\d+).*\)$");

        $matches = array();
        foreach ($params as $param) {
            preg_match("/" . $param['pattern'] . "/im", $StatusString, $matches);
            $out[$param['name']] = $matches[1];
        }
        /*
        *	Parse player data
        *	- locate # at begining of line to signify start of table
        *	- locate second player count "\d+ users" which is the end of the table
        *	- parse the table
        */

        preg_match('/#(\d+)\s+("GOTV")\s*(\w*)\s*(\w*)\s*(\d*)[\r\n]+/im', $StatusString, $matches);

        if (count($matches) > 0) {
            $out['gotv']['bot'] = [
                'id' => $matches[1],
                'botname' => $matches[2],
                'type' => $matches[3],
                'status' => $matches[4],
                'tickrate' => $matches[5]];

            $StatusString = str_replace($matches[0], "", $StatusString);
        }

        $botAmount = 0;
        while (preg_match('/#\s*(\d+)\s+("\w+")\s*(\w*)\s*(\w*)\s*(\d*)[\r\n]+/im', $StatusString, $matches)) {
            $out['bots']['bot' . ($botAmount + 1)] = [
                'id' => $matches[1],
                'botname' => $matches[2],
                'type' => $matches[3],
                'status' => $matches[4],
                'tickrate' => $matches[5]];
            $botAmount++;
            $StatusString = str_replace($matches[0], "", $StatusString);
        }

        $out['botAmount'] = $botAmount;
        // Isolate player data table
        preg_match("/^#/im", $StatusString, $matches, PREG_OFFSET_CAPTURE);
        $iStart = $matches[0][1];

        preg_match("/#end/im", $StatusString, $matches, PREG_OFFSET_CAPTURE);
        $iEnd = $matches[0][1];

        $PlayerDataString = trim(substr($StatusString, $iStart, $iEnd - $iStart));

        // Convert to an array
        $PlayerDataArray = preg_split("/(\r\n|\n|\r)/", $PlayerDataString);

        // Parse header
        $header = explode_by_whitespace(array_shift($PlayerDataArray));


        // Parse player data
        $playerAmount = 0;
        $PlayerList = array();
        foreach ($PlayerDataArray as $player) {
            $PlayerList[$playerAmount++] = parse_player_line($player);
        }
        $out['playerAmount'] = $playerAmount;
        $out['players'] = $PlayerList;

        return $out;
    }

    function parse_player_line($string): array
    {
        $temp = array();
        $player = explode_by_whitespace(substr($string, 4)); // The rest is whitespace delimited (not space delimited)
        $temp = [
            'id' => trim(substr($string, 2, 2)),
            'unknown' => $player[0],
            'name' => $player[1],
            'steamid' => $player[2],
            'timeInServer' => $player[3],
            'ping' => $player[4],
            'loss' => $player[5],
            'state' => $player[6],
            'rate' => $player[7],
            'ip' => $player[8]
        ];
        return $temp;
    }

    function explode_by_whitespace($string)
    {
        $pattern = "/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/";
        return preg_split($pattern, $string, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    }
}
