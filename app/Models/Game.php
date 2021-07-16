<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description'
    ];

    //A game can have an infinite number of parties
    public function party (){
        return $this -> hasMany(Party::class);
    }
}
