<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $products;

	public function add(Product $product)
	{
		$this->products[] = $product;
	}

	public function products()
	{
		return $this->products;
	}

	public function totalCost()
	{
		$total = 0;

		foreach ($this->products as $product) {
			$total += $product->cost();
		}

		return $total;
	}
}
