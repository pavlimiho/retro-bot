<?php

use App\Models\TrashGame;
use Illuminate\Database\Seeder;

class TrashGameSeeder extends Seeder
{
    public $trashGames = [
       ['name' => 'Among Us', 'code' => 'Au']  
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->trashGames as $game) {
            if (TrashGame::where('code', $game['code'])->count() === 0) {
                TrashGame::create([
                    'name' => $game['name'],
                    'code' => $game['code']
                ]);
            }
        }
    }
}
