<?php

use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = config("teams");
        foreach ($teams as $code => $info)
        {
            // Create data array
            $dataInfo = explode(",", $info);
            $data = [
                'code' => $code,
                'name' => $dataInfo[0],
                'display_code' => $dataInfo[1],
                'fifa_ranking' => $dataInfo[2],
                'group' => $dataInfo[3]
            ];
            
            // Check if team exists
            $team = Team::where("code", $code)->first();
            if ($team)
            {
                $team->update($data);                
            }
            else
            {
                $team = Team::create($data);
            }
        }
    }
}
