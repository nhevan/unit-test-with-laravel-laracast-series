<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProphecyTest extends TestCase
{
    /**
     * @test
     * first prophecy test
     */
    public function first_prophecy_test()
    {
    	//arrange
        $wheel = $this->prophesize(Wheel::class);
        $car = new Car($wheel->reveal());
    
        //act
        $wheel->rotate()->shouldBeCalled();
        $car->moveForward();
    	
    
        //assert
        
    }
}

class Wheel{
	public function rotate()
	{
		echo "\nrotating wheel ....";

		return $this;
	}
}

class Car{
	protected $wheel;

	function __construct(Wheel $wheel)
	{
		$this->wheel = $wheel;
	}
	public function moveForward()
	{
		$this->wheel->rotate();
		echo "\nmoving forward\n";
		return $this;
	}
}
