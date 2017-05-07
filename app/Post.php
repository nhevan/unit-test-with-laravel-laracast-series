<?php

namespace App;

use App\Traits\Likeability;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use Likeability;
}
