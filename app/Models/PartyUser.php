<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'party_id'
    ];

    // A PartyUser is owned by only one User (n:1).
    public function user (){
        return $this -> belongsTo(User::class);
    }

    // A PartyUser is owned by only one Party (n:1).
    public function party (){
        return $this -> belongsTo(Party::class);
    }
}
