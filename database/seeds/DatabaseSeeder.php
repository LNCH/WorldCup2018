<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table("teams")->truncate();
        DB::table("matches")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

         $this->call(TeamSeeder::class);
         $this->call(MatchSeeder::class);
    }
}
