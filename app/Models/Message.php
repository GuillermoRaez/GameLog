<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'party_id',
        'user_id'
    ];

    // A message belongs to only one User
    public function user (){
        return $this -> belongsTo(User::class);
    }

    // A message belongs to only one Party
    public function party (){
        return $this -> belongsTo(Party::class);
    }

}
