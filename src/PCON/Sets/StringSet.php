<?php
/**
 * PCON: PHP Containers.
 * 
 * Copyright (c) 2011, Omercan Sebboy <osebboy@gmail.com>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE file 
 * that was distributed with this source code.
 *
 * @author     Omercan Sebboy (www.osebboy.com)
 * @package    PCON\Sets
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sets;

use Closure, SplFixedArray;

/**
 * StringSet is an associative array which holds unique string values.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class StringSet implements SetInterface
{
	/**
	 * String Set ontainer.
	 * 
	 * @var array
	 */
	protected $set = array();
	
	/**
	 * Build container with an array of string values, which removes
	 * any values in the set prior to inserting new ones.
	 * 
	 * @param  array $array
	 * @return void
	 */
	public function build(array $array)
	{
		$this->set = array();
		foreach ($array as $str)
		{
			$this->insert($str);
		}
	}
	
	/**
	 * Clears the container and removes all values.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->set = array();
	}
	
	/**
	 * Tests whether value is in the container.
	 * 
	 * @param  string $value 
	 * @return boolean
	 */
	public function contains($value)
	{
		return isset($this->set[md5($value)]);
	}
	
	/**
	 * Runs a predicate on each value and find the elements
	 * that satisfy the predicate.
	 * 
	 * $set = new StringSet();
	 * $set->build(array('one', 'two', 'three', 'four', 'five'));
	 * 
	 * // find the strings which includes the letter 'o'
	 * $p = function($string) {
	 *		return stripos($string, 'o') !== false;
	 * };
	 * 
	 * $this->find($p); // returns array('one','two','four')
	 * 
	 * @param  Closure $predicate
	 * @return array | values found, original keys are perserved
	 */
	public function find(Closure $predicate)
	{
		return array_filter($this->set, $predicate);
	}
	
	/**
	 * Iterator.
	 * 
	 * @return SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_values($this->set));
	}
	
	/**
	 * Inserts a string element to the set.
	 * 
	 * @throws E_USER_WARNING if $value is not string
	 * @param  string $value
	 * @return void
	 */
	public function insert($value)
	{
		if (!is_string($value))
		{
			return trigger_error('StringSet expects value to be string', E_USER_WARNING);
		}
		$this->set[md5($value)] = $value;
	}
	
	/**
	 * Checks to see if set is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->set;
	}
	
	/**
	 * Removes a string element from the set.
	 * 
	 * @param  string $value
	 * @return boolean | false if cannot remove, true otherwise
	 */
	public function remove($value)
	{
		$h = md5($value);
		if (isset($this->set[$h]))
		{
			unset($this->set[$h]);
			return true;
		}
		return false;
	}

	/**
	 * Size of the container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->set);
	}
	
	/**
	 * To array.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->set;
	}
}
?>