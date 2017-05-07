<?php

namespace App\Traits;

use App\Like;
use Illuminate\Support\Facades\Auth;

trait Likeability{
	public function likes()
	{
		return $this->morphMany(Like::class, 'likeable');
	}

	/**
	 * authenticated user likes the post
	 * @return [type] [description]
	 */
	public function like()
	{
		$like = new Like(['user_id' => Auth::id()]);
		$this->likes()->save($like);
	}

	/**
	 * a user can unlike a post
	 * @return [type] [description]
	 */
	public function unlike()
	{
		return $this->likes()->where('user_id', Auth::id())->delete();
	}

	/**
	 * a user can toggle the status of like for a given resource
	 * @return [type] [description]
	 */
	public function toggleLike()
	{
		if ($this->isLiked) {
			return $this->unlike();
		}

		return $this->like();
	}

	/**
	 * returns the total number of likes on a given model
	 * @return [type] [description]
	 */
	public function likesCount()
	{
		return $this->likes()->count();
	}

	public function getIsLikedAttribute()
	{
		return !! $this->likes()->where('user_id', Auth::id())->count();
	}
}