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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function import($data_source = '')
    {
        $provider = self::DEFAULT_PROVIDER;
        
        if (!empty($data_source)) {
            if (filter_var($data_source, FILTER_VALIDATE_URL)) {
                $provider = $data_source;
            }
        }
        
        $json_response = json_decode(file_get_contents($provider), true);
        
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
        ], 200);
    }
}
