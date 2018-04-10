<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $dates = [
        'match_date'
    ];

    public $difference;

    public function homeTeam()
    {
        return $this->hasOne(Team::class, "id", "home_team_id");
    }

    public function awayTeam()
    {
        return $this->hasOne(Team::class, "id", "away_team_id");
    }
}
