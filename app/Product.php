<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $name;
	protected $price;

	public function __construct($name, $price)
	{
		$this->name = $name;
		$this->price = $price;
	}

    public function name()
    {
    	return $this->name;
    }

    /**
     * Gets the value of price.
     *
     * @return mixed
     */
    public function price()
    {
        return $this->price;
    }
}
