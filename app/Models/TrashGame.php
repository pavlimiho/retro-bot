<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrashGame extends Model
{
    /**
     * Set relationship with members
     * 
     * @return Member
     */
    public function members() 
    {
        return $this->belongsToMany(Member::class);
    }
}
