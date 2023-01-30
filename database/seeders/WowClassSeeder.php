<?php

use App\Models\WowClass;
use App\Models\WowSpecialization;
use Illuminate\Database\Seeder;

class WowClassSeeder extends Seeder
{
    public $wowClasses = [
        ['name' => 'Death Knight', 'color' => '#c41f3b'],
        ['name' => 'Demon Hunter', 'color' => '#a330c9'],
        ['name' => 'Druid', 'color' => '#ff7d0a'],
        ['name' => 'Evoker', 'color' => '#33937f'],
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
    
    public $wowSpecializations = [
        ['wow_class' => 'Death Knight', 'name' => 'Blood'],
        ['wow_class' => 'Death Knight', 'name' => 'Frost'],
        ['wow_class' => 'Death Knight', 'name' => 'Unholy'],
        ['wow_class' => 'Demon Hunter', 'name' => 'Havoc'],
        ['wow_class' => 'Demon Hunter', 'name' => 'Vengeance'],
        ['wow_class' => 'Druid', 'name' => 'Balance'],
        ['wow_class' => 'Druid', 'name' => 'Feral'],
        ['wow_class' => 'Druid', 'name' => 'Guardian'],
        ['wow_class' => 'Druid', 'name' => 'Restoration'],
        ['wow_class' => 'Evoker', 'name' => 'Devastation'],
        ['wow_class' => 'Evoker', 'name' => 'Preservation'],
        ['wow_class' => 'Hunter', 'name' => 'Beast Mastery'],
        ['wow_class' => 'Hunter', 'name' => 'Marksmanship'],
        ['wow_class' => 'Hunter', 'name' => 'Survival'],
        ['wow_class' => 'Mage', 'name' => 'Arcane'],
        ['wow_class' => 'Mage', 'name' => 'Fire'],
        ['wow_class' => 'Mage', 'name' => 'Frost'],
        ['wow_class' => 'Monk', 'name' => 'Brewmaster'],
        ['wow_class' => 'Monk', 'name' => 'Mistweaver'],
        ['wow_class' => 'Monk', 'name' => 'Windwalker'],
        ['wow_class' => 'Paladin', 'name' => 'Holy'],
        ['wow_class' => 'Paladin', 'name' => 'Protection'],
        ['wow_class' => 'Paladin', 'name' => 'Retribution'],
        ['wow_class' => 'Priest', 'name' => 'Discipline'],
        ['wow_class' => 'Priest', 'name' => 'Holy'],
        ['wow_class' => 'Priest', 'name' => 'Shadow'],
        ['wow_class' => 'Rogue', 'name' => 'Assassination'],
        ['wow_class' => 'Rogue', 'name' => 'Outlaw'],
        ['wow_class' => 'Rogue', 'name' => 'Subtlety'],
        ['wow_class' => 'Shaman', 'name' => 'Elemental'],
        ['wow_class' => 'Shaman', 'name' => 'Enhancement'],
        ['wow_class' => 'Shaman', 'name' => 'Restoration'],
        ['wow_class' => 'Warlock', 'name' => 'Affliction'],
        ['wow_class' => 'Warlock', 'name' => 'Demonology'],
        ['wow_class' => 'Warlock', 'name' => 'Destruction'],
        ['wow_class' => 'Warrior', 'name' => 'Arms'],
        ['wow_class' => 'Warrior', 'name' => 'Fury'],
        ['wow_class' => 'Warrior', 'name' => 'Protection']
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
        
        foreach ($this->wowSpecializations as $specialization) {
            if (WowSpecialization::where('name', $specialization['name'])->count() === 0) {
                WowSpecialization::create([
                    'wow_class_id' => WowClass::where('name', $specialization['wow_class'])->firstOrFail()['id'],
                    'name' => $specialization['name']
                ]);
            }
        }
    }
}
