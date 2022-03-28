<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;
    
    public function encounters()
    {
        return $this->hasMany(Encounter::class)->where('name', '<>', 'Trash Drop');
    }
}
