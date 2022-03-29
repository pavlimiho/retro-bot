<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'member_id', 'name', 'discriminator', 'wow_class_id', 'sim_link', 'last_sim_update'
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
        return $this->belongsToMany(TrashGame::class)->withTimestamps();
    }
    
    public function wowClass()
    {
        return $this->belongsTo(WowClass::class);
    }
    
    public function simResults()
    {
        return $this->hasMany(SimResult::class);
    }
    
    public function getLastSimAttribute()
    {
        $sim = $this->simResults()->orderBy('id', 'desc')->first();
        
        if ($sim) {
            return $sim->json;
        } else {
            return null;
        }
    }
}
