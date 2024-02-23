<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    


    public function index(Anime $anime)
    {
        $seasons = $anime->seasons()->with('episodes')->get();

        return view('seasons.index')->with('seasons',$seasons)->with('anime', $anime);
    }


}
