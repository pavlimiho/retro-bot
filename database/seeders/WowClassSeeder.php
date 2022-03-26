<?php

use App\Models\WowClass;
use Illuminate\Database\Seeder;

class WowClassSeeder extends Seeder
{
    public $wowClasses = [
        ['name' => 'Death Knight', 'color' => '#c41f3b'],
        ['name' => 'Demon Hunter', 'color' => '#a330c9'],
        ['name' => 'Druid', 'color' => '#ff7d0a'],
        ['name' => 'Hunter', 'color' => '#abd473'],
        ['name' => 'Mage', 'color' => '#40c7eb'],
        ['name' => 'Monk', 'color' => '#00ff96'],
        ['name' => 'Paladin', 'color' => '#f58cba'],
        ['name' => 'Priest', 'color' => '#ffffff'],
        ['name' => 'Rogue', 'color' => '#fff569'],
        ['name' => 'Shaman', 'color' => '#0070de'],
        ['name' => 'Warlock', 'color' => '#8787ed'],
        ['name' => 'Warrior', 'color' => '#c79c6e']
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->wowClasses as $class) {
            if (WowClass::where('name', $class['name'])->count() === 0) {
                WowClass::create([
                    'name' => $class['name'],
                    'color' => $class['color']
                ]);
            }
        }
    }
}
