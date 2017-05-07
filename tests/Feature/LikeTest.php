<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikeTest extends TestCase
{
    use DatabaseTransactions;

    protected $post;

    public function setUp()
    {
    	parent::setup();

    	//arrange
        $this->post = factory(Post::class)->create();
        $this->signIn();
    }
    /**
     * @test
     * a logged in user can like a post
     */
    public function a_logged_in_user_can_like_a_post()
    {
        //act
        $this->post->like();
    
        //assert
        $this->assertDatabaseHas('likes', [
        	'user_id' => $this->user->id,
        	'likeable_id' => $this->post->id,
        	'likeable_type' => get_class($this->post),
    	]);

        $this->assertTrue($this->post->isLiked);
    }

    /**
     * @test
     * a user can unlike a post
     */
    public function a_user_can_unlike_a_post()
    {
    	//act
        $this->post->like();
        $this->post->unlike();
    
        //assert
        $this->assertDatabaseMissing('likes', [
        	'user_id' => $this->user->id,
        	'likeable_id' => $this->post->id,
        	'likeable_type' => get_class($this->post),
    	]);

        $this->assertFalse($this->post->isLiked);
    }

    /**
     * @test
     * a user can toggle a post like
     */
    public function a_user_can_toggle_a_post_like()
    {
        $this->post->toggleLike();
        $this->assertTrue($this->post->isLiked);

        $this->post->toggleLike();
        $this->assertFalse($this->post->isLiked);
    }

    /**
     * @test
     * a post knows how many count it has
     */
    public function a_post_knows_how_many_count_it_has()
    {
    	//act
        $this->post->like();

        $this->assertEquals(1, $this->post->likesCount());
    }
}
