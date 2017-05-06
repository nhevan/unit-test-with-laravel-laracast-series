<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function scopeTrending($query)
    {
    	$query->orderBy('reads', 'DESC')->get();
    }
}
