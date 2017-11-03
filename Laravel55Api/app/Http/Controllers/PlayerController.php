<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    const DEFAULT_PROVIDER = 'https://fantasy.premierleague.com/drf/bootstrap-static';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Player::all(['id', 'first_name', 'last_name']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return $player;
    }

    public function import(Request $request)
    {
        $provider = self::DEFAULT_PROVIDER;
        
        $data_source = $request->input('data_source');
        if (!empty($data_source)) {
            if (filter_var($data_source, FILTER_VALIDATE_URL)) {
                $provider = $data_source;
            } else {
                return response()->json([
                    'error' => 'The Data Source is not a valid URL'
                ], 404);
            }
        }
        
        $json_response = json_decode(file_get_contents($provider), true);
        
        if (!isset($json_response['elements'])) {
            return response()->json([
                'error' => 'Invalid Data Source'
            ], 404);
        }
        
        $players = $json_response['elements'];
        $cleaned_players = array();
        foreach ($players as $player) {
            $cleaned_players[] = array(
                'id'            => $player['id'],
                'first_name'    => $player['first_name'],
                'last_name'     => $player['second_name'],
                'form'          => $player['form'],
                'total_points'  => $player['total_points'],
                'influence'     => $player['influence'],
                'creativity'    => $player['creativity'],
                'threat'        => $player['threat'],
                'ict_index'     => $player['ict_index']
            );
        }
        
        Player::insertOnDuplicateKey($cleaned_players);
        
        return response()->json([
            'success' => 'Import Complete'
        ], 201);
    }
}
