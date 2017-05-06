<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
	protected $product;

	public function setUp()
	{
		$this->product = new Product('Fallout 4', 59);
	}

    /**
     * @test
     * checks if a product has a name
     */
    public function a_product_has_a_name()
    {
    	$this->assertEquals('Fallout 4', $this->product->name());
    }

    /**
     * @test
     * checks if a product has a price
     */
    public function a_product_has_a_price()
    {
    	$this->assertEquals(59, $this->product->price());
    }
}
