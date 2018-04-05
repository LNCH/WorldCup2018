<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
