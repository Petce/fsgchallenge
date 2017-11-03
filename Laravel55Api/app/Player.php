<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Player extends Model
{
    use InsertOnDuplicateKey;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'form',
        'total_points',
        'influence',
        'creativity',
        'threat',
        'ict_index'
    ];
}
