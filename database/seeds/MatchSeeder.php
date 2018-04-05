<?php

use App\Match;
use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("matches")->truncate();
        
        $matches = config("matches");
        
        foreach ($matches as $date => $times)
        {
            foreach ($times as $time => $matchString)
            {
                $this->createMatch($date, $time, $matchString);
            }
        }        
    }
    
    private function createMatch($date, $time, $data)
    {
        $matches = explode("|", $data);
        foreach ($matches as $match)
        {
            $dataInfo = explode(",", $match);
                
            $homeTeam = Team::where("code", $dataInfo[0])->first();
            $awayTeam = Team::where("code", $dataInfo[1])->first();

            if ($homeTeam && $awayTeam)
            {
                $data = [
                    'match_date' => $date . " " . $time . ":00",
                    'channel' => $dataInfo[2],
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id
                ];

                // Check if team exists
                $match = Match::where("home_team_id", $homeTeam->id)
                    ->where("away_team_id", $awayTeam->id)    
                    ->first();
                if ($match)
                {
                    $match->update($data);                
                }
                else
                {
                    $match = Match::create($data);
                }
            }
        }
    }
}
