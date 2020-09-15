<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_id', 'name', 'discriminator'
    ];
    
    /**
     * Set relationship with won gambles
     * 
     * @return Gamble
     */
    public function gamblesWon() 
    {
        return $this->hasMany(Gamble::class, 'winner_id');
    }
    
    /**
     * Set relationship with lost gambles
     * 
     * @return Gamble
     */
    public function gamblesLost() 
    {
        return $this->hasMany(Gamble::class, 'loser_id');
    }
    
    /**
     * Set relationship with trash games
     * 
     * @return TrashGame
     */
    public function trashGames() 
    {
        return $this->belongsToMany(TrashGame::class);
    }
}
