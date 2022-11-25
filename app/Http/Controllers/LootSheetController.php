<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Instance;
use App\Models\Member;
use App\Models\WowClass;
use Illuminate\Http\Request;

class LootSheetController extends Controller
{
    private $tier = 'Vault of the Incarnates';
    
    public function index() 
    {
        $members = Member::with(['wowClass', 'simResults'])->orderBy('name')->get();
        $instance = Instance::where('name', $this->tier)->first();
        $encounters = $instance->encounters()->orderBy('order')->get();
        $isFluid = true;
        $noHeader = true;
        
        return view('loot-sheet', compact('members', 'instance', 'encounters', 'isFluid', 'noHeader'));
    }
}
