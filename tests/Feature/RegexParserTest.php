<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\RegexParser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegexParserTest extends TestCase
{
    /**
     * @test
     * it finds a string
     */
    public function it_finds_a_string()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->find('www');
    
        //assert
        $this->assertTrue($regex->test('www'));
        $this->assertFalse($regex->test('wrong'));
    }

    /**
     * @test
     * it has a alias for the find method
     */
    public function it_has_a_alias_for_the_find_method()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
		$regex->then('www');
    
        //assert
        $this->assertTrue($regex->test('www'));
        $this->assertFalse($regex->test('wrong'));
    }

    /**
     * @test
     * it checks for anything
     */
    public function it_checks_for_anything()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->find('www')->anything();
    	
        //assert
    	$this->assertTrue($regex->test('wwwanything'));
    	$this->assertTrue($regex->test('wwwnothing'));
    	$this->assertFalse($regex->test('ww'));
    }

    /**
     * @test
     * it may or may not have a given value
     */
    public function it_may_or_may_not_have_a_given_value()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->find('www')->maybe("hola");
    	
        //assert
        $this->assertTrue($regex->test('wwwhola'));
        $this->assertTrue($regex->test('www'));

        $this->assertFalse($regex->test('ww'));
    }

    /**
     * @test
     * it can chain methods
     */
    public function it_can_chain_methods()
    {
        $regex = RegexParser::make()->maybe('www.')->find('nhevan')->then('neela')->anything();	
    
        //assert
        $this->assertTrue($regex->test('nhevanneela'));
        $this->assertTrue($regex->test('nhevanneela.com'));
        $this->assertTrue($regex->test('www.nhevanneela.com'));
        $this->assertTrue($regex->test('nhevanneelaAnything.com'));
    }

    /**
     * @test
     * it can exclude a given string
     */
    public function it_can_exclude_a_given_string()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->find('foo')->anythingBut('bar')->then('biz');
    
        //assert
        $this->assertTrue($regex->test('foobiz'));
        $this->assertTrue($regex->test('fooAnythingbiz'));
        $this->assertFalse($regex->test('foobarbiz'));
    }

    /**
     * @test
     * it begins with a given string
     */
    public function it_begins_with_a_given_string()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->beginsWith('bar')->anything();
    
        //assert
        $this->assertTrue($regex->test('baranything'));
        $this->assertFalse($regex->test('somethingbaranything'));
    }

    /**
     * @test
     * it ends with a given string
     */
    public function it_ends_with_a_given_string()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->anything()->endsWith('bar');
    
        //assert
        $this->assertTrue($regex->test('anythingbar'));
        $this->assertFalse($regex->test('barAnything'));
    }

    /**
     * @test
     * it can ignore case sensitivity
     */
    public function it_can_ignore_case_sensitivity()
    {
    	//arrange
        $regex = RegexParser::make();
    
        //act
    	$regex->find('foo')->ignoreCase();
    
        //assert
        $this->assertTrue($regex->test('foo'));
        $this->assertTrue($regex->test('FOO'));

		$this->assertFalse($regex->test('bar'));
    }
}
