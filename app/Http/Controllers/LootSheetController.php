<?php

namespace App\Http\Controllers;

use App\Models\WowClass;
use Illuminate\Http\Request;

class LootSheetController extends Controller
{
    public function index() 
    {
        return view('loot-sheet');
    }
}
