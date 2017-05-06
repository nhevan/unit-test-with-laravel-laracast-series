<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{

/**
 * @test
 * a order has many products
 */
public function a_order_has_many_products()
{
    $order = $this->createOrderWithProducts();

    //assert
    $this->assertCount(2, $order->products());
}


/**
 * @test
 * a order has a total cost method that returns summation of all the products cosr
 */
public function a_order_can_determine_the_total_cost_of_all_its_products()
{
	$order = $this->createOrderWithProducts();

    //assert
    $this->assertEquals(66, $order->totalCost());
}

/**
 * creates a order with 2 initial products in it
 * @return [type] [description]
 */
private function createOrderWithProducts()
{
   	//arrange
	$order = new Order;
	$product1 = new Product('Fallout 4', 59);
	$product2 = new Product('Pillowcase', 7);

	//act
	$order->add($product1);
   	$order->add($product2);
   
   return $order;
}

}
