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
 * Object Set is a lightweight associative container that stores unique objects.
 * 
 * @see SetInterface
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class ObjectSet implements SetInterface
{
	/**
	 * Object set container.
	 * 
	 * @var array
	 */
	protected $set = array();
	
	/**
	 * Build container with an array of objects, which removes
	 * any objects in the set prior to inserting new objects.
	 * 
	 * @see insert()
	 * @param  array $array
	 * @return void
	 */
	public function build(array $array)
	{
		$this->set = array();
		foreach ($array as $obj)
		{
			$this->insert($obj);
		}
	}
	
	/**
	 * Clears the container and removes all objects.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->set = array();
	}
	
	/**
	 * Tests whether object is in the container,
	 * 
	 * @param  object $value 
	 * @return boolean
	 */
	public function contains($value)
	{
		return isset($this->set[spl_object_hash($value)]);
	}

	/**
	 * Runs a predicate on the set objects and finds the objects
	 * that satisfy the predicate.
	 * 
	 *  $obj1 = new \stdClass();
	 *  $obj1->name = 'cat';
	 *  
	 *	$obj2 = new \stdClass();
	 *	$obj2->name = 'cow';
	 *
	 *	$obj3 = new \stdClass();
	 *	$obj3->name = 'fox';
	 *
	 *	$obj4 = new \stdClass();
	 *	$obj4->name = 'ant';
	 *	
	 *	// function to check if object is instance of stdClass and 
	 *  // the letter 'o' exists in its name
	 *	$p = function($object) {
	 *		return ($object instanceOf \stdClass && 
	 *				stripos($object->name, 'o') !== false);
	 *	};
	 * 
	 * $this->find($p); // returns $obj2 and $obj3
	 * 
	 * @param  Closure $predicate
	 * @return array
	 */
	public function find(Closure $predicate)
	{
		return array_filter($this->set, $predicate);
	}
	
	/**
	 * Iterator.
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_values($this->set));
	}
	
	/**
	 * Inserts an object to the set, 0(1) complexity.
	 * 
	 * @throws E_USER_WARNING if $value is not an object
	 * @param  object $value
	 * @return void
	 */
	public function insert($value)
	{
		if (!is_object($value))
		{
			return trigger_error('ObjectSet expects value to be object', E_USER_WARNING);
		}
		$this->set[spl_object_hash($value)] = $value;
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
	 * Removes an object from the set.
	 * 
	 * @param  object $value
	 * @return boolean | false if cannot remove, true otherwise
	 */
	public function remove($value)
	{
		$h = spl_object_hash($value);
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
		return (int) count($this->set);
	}

	/**
	 * Set to array.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->set;
	}
}
