<?php

use App\Post;

function createPost()
{
	return factory(Post::class)->create();
}