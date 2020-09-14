<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamble extends Model
{
    /**
     * Set relationship with winner
     * 
     * @return Member
     */
    public function winner() 
    {
        return $this->belongsTo(Member::class, 'id', 'winner_id');
    }
    
    /**
     * Set relationship with loser
     * 
     * @return Member
     */
    public function loser() 
    {
        return $this->belongsTo(Member::class, 'id', 'loser_id');
    }
}
