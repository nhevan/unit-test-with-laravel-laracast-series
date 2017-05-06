<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     * fetch trending articles
     */
    public function fetch_trending_articles()
    {
    	//arrange
        factory('App\Article', 3)->create();
        factory('App\Article')->create(['reads' => 10]);
        $most_popular = factory('App\Article')->create(['reads' => 20]);
        
        //act
    	$articles = Article::trending();
    
        //assert
        $this->assertEquals($most_popular->id, $articles->first()->id);
    }
}
