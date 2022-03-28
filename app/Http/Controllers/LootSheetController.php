<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Instance;
use App\Models\Member;
use App\Models\WowClass;
use Illuminate\Http\Request;

class LootSheetController extends Controller
{
    private $tier = 'Sepulcher of the First Ones';
    
    public function index() 
    {
        $members = Member::with('wowClass')->orderBy('name')->get();
        $instance = Instance::where('name', $this->tier)->first();
        $encounters = $instance->encounters()->orderBy('order')->get();
        
        return view('loot-sheet', compact('members', 'instance', 'encounters'));
    }
}
