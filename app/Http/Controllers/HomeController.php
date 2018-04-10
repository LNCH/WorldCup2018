<?php

namespace App\Http\Controllers;

use App\Match;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $teams = Team::orderBy("group")->orderBy("name")->get();
        
        return view('home', compact("teams"));
    }

    public function groups()
    {
        $groups = Team::getSortedGroups();

        return view("groups", compact("groups"));
    }

    public function matches()
    {
        $matches = Match::orderBy("match_date")->get();

        return view("matches", compact("matches"));
    }
}
