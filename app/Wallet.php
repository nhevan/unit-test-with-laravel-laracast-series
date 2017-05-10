<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public function balance()
    {
    	return "1000";
    }
}
