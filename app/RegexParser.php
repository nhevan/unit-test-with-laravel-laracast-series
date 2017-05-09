<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegexParser extends Model
{
	protected $expression;
	protected $caseSensitivity;

	/**
	 * returns a chainable static version of the class
	 * @return [type] [description]
	 */
	public static function make()
	{
		return new static;
	}

	/**
	 * string must start with the given string
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function beginsWith($value)
	{
		$value = $this->sanitize($value);
		$this->expression .= '^'.$value;

		return $this;
	}

	/**
	 * string must end with the given string
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function endsWith($value)
	{
		$value = $this->sanitize($value);
		$this->expression .= $value.'$';

		return $this;
	}

	/**
	 * finds a given string
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function find($value)
	{
		$value = $this->sanitize($value);
		$this->expression .= $value;

		return $this;
	}

	/**
	 * instructs the class to ignore case sensitivity
	 * @return [type] [description]
	 */
	public function ignoreCase()
	{
		$this->caseSensitivity = 'i';

		return $this;
	}

	/**
	 * alias for the find method
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function then($value)
	{
		return $this->find($value);
	}

	/**
	 * matches any character for any number of times
	 * @return [type] [description]
	 */
	public function anything()
	{
		$this->expression .= '.*';

		return $this;
	}

	/**
	 * matches any character except for the given variable
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function anythingBut($value)
	{
		$value = $this->sanitize($value);
		$this->expression .= '(?!'.$value.').*?';

		return $this;
	}

	/**
	 * it checks for a given string which may or may not be there
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function maybe($value)
	{
		$value = $this->sanitize($value);
		$this->expression .= '('.$value.')?';

		return $this;
	}

	/**
	 * checks the expression with a given variable
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function test($value)
	{
		return (bool) preg_match($this->getRegex(), $value);
	}

	/**
	 * returns the compiled regex expression
	 * @return [type] [description]
	 */
	public function getRegex()
	{
		$regex = '/'.$this->expression.'/';
		if($this->caseSensitivity == 'i') $regex .= 'i';
		
		return $regex;
	}

	/**
	 * sanitizes a given string
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function sanitize($value)
	{
		return preg_quote($value);
	}

}
