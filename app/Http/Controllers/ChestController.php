<?php

namespace App\Http\Controllers;

use App\Models\Chest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChestController extends Controller
{
    //
    public function getAllChests()
    {
        $chests = Chest::all();
        return response()->json($chests);
    }
}
