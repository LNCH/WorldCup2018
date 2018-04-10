<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    public function getFlagAttribute()
    {
        $flagCode = strtolower(substr($this->code, 0, 2));
        if ($flagCode == "gb") {
            $flagCode = "gb-eng";
        }
        
        return "<span class='flag-icon flag-icon-$flagCode'></span>";
    }

    // Stat functions

    public function getPlayedAttribute()
    {
        $team = $this;
        $played = Match::where("match_date", "<", DB::raw("NOW()"))
            ->where(function ($query) use ($team) {
                $query->where("home_team_id", $team->id)
                    ->orWhere("away_team_id", $team->id);
            })
            ->count();

        return $played;
    }

    public function getWonAttribute()
    {
        $team = $this;

        $won = Match::where(function ($query) use ($team) {
                $query->where(function ($query) use ($team) {
                    $query->where("home_team_id", $team->id)
                        ->whereNotNull("home_score")
                        ->whereRaw("home_score > away_score");
                })
                ->orWhere(function ($query) use ($team) {
                    $query->where("away_team_id", $team->id)
                        ->whereNotNull("away_score")
                        ->whereRaw("away_score > home_score");
                });
            })
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->count();

        return $won;
    }

    public function getDrawnAttribute()
    {
        $team = $this;

        $drawn = Match::where(function ($query) use ($team) {
                $query->where("home_team_id", $team->id)
                    ->orWhere("away_team_id", $team->id);
            })
            ->whereRaw("home_score = away_score")
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->count();

        return $drawn;
    }

    public function getLostAttribute()
    {
        $team = $this;

        $won = Match::where(function ($query) use ($team) {
                $query->where(function ($query) use ($team) {
                    $query->where("home_team_id", $team->id)
                        ->whereNotNull("home_score")
                        ->whereRaw("home_score < away_score");
                })
                ->orWhere(function ($query) use ($team) {
                    $query->where("away_team_id", $team->id)
                        ->whereNotNull("away_score")
                        ->whereRaw("away_score < home_score");
                });
            })
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->count();

        return $won;
    }

    public function getGoalsForAttribute()
    {
        $homeGoals = Match::where("home_team_id", $this->id)
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->sum("home_score");

        $awayGoals = Match::where("away_team_id", $this->id)
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->sum("away_score");

        return $homeGoals + $awayGoals;
    }

    public function getGoalsAgainstAttribute()
    {
        $homeGoals = Match::where("home_team_id", $this->id)
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->sum("away_score");

        $awayGoals = Match::where("away_team_id", $this->id)
//            ->where("match_date", "<", DB::raw("NOW()"))
            ->whereNotNull("home_score")
            ->whereNotNull("away_score")
            ->sum("home_score");

        return $homeGoals + $awayGoals;
    }

    public function getGoalDifferenceAttribute()
    {
        return $this->goalsFor - $this->goalsAgainst;
    }

    public function getPointsAttribute()
    {
        return ($this->won * 3) + $this->drawn;
    }

    public static function getSortedGroups()
    {
        $groups = collect();
        $groupLetters = Team::select("group")->distinct()->orderBy("group")->pluck("group");

        foreach ($groupLetters as $letter) {
            $groups[$letter] = Team::where("group", $letter)->get();
        }

        $sortedGroups = [];
        foreach($groups as $letter => $group) {
            $sortedGroups[$letter] = $group->sort(function($a, $b)
            {
                // Sort by points
                if($a->points != $b->points) {
                    return $a->points > $b->points ? -1 : 1;
                }

                // Sort by goal difference
                if($a->goalDifference != $b->goalDifference) {
                    return $a->goalDifference > $b->goalDifference ? -1 : 1;
                }

                // Sort by goals scored
                if($a->goalsFor != $b->goalsFor) {
                    return $a->goalsFor > $b->goalsFor ? -1 : 1;
                }

                // Even
                return 0;
            });
        }

        return $sortedGroups;
    }
}
