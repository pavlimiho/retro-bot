<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\WowClass;
use Illuminate\Http\Request;

class LootSheetController extends Controller
{
    public function index() 
    {
        $members = Member::with('wowClass')->orderBy('name')->get();
        
        return view('loot-sheet', compact('members'));
    }
}
