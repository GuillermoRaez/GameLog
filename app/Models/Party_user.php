<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'party_id'
    ];

    //A party_user can only have one User
    public function user (){
        return $this -> belongsTo(User::class);
    }

    //A party_user can only have one Party
    public function party () {
        return $this -> belongsTo(Party::class);
    }

}
