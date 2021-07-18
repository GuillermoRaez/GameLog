<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    
    use HasFactory;

     protected $fillable = [
         'name',
         'game_id'
     ];
    

    //A party can be in many user_parties (1:n).
    public function Party_User (){
        return $this -> HasMany(PartyUser::class);
    }

    //A party can only have one game (1:1).
    public function game (){
        return $this -> belongsTo(Game::class);
    }

    //A party can have many messages (1:n).
    public function message (){
        return $this -> HasMany(Message::class);
    }

}

