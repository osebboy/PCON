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
 * @package    PCON\Maps
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Maps;

use Closure, IteratorAggregate, ArrayIterator;

/**
 * Map is a lightweight associative container that stores elements formed 
 * by the combination of a key value and a mapped value.
 * 
 * Map does not have an internal iterator as most might expect. This is
 * mainly because of SPL Iterator's performance related issues.
 * Map implements the IteratorAggregate interface which provides an
 * external iterator to iterate over the container elements, performing
 * the same as regular PHP arrays. 
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class Map implements MapInterface, IteratorAggregate
{
	/**
	 * Container.
	 * 
	 * @var array
	 */
	protected $map = array();

	/**
	 * Assigns an array to the container removing all previous elements 
	 * in the container.
	 * 
	 * @param array $array
	 * @return void
	 */
	public function assign(array $array)
	{
		$this->map = $array;
	}

	/**
	 * Clears the container and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->map = array();
	}

	/**
	 * Erases the key and its value.
	 * 
	 * @param mixed $key | integer or string
	 * @return mixed | removed value or null if $key doesn't exists
	 */
	public function erase($key)
	{
		if (isset($this->map[$key]))
		{
			$ret = $this->map[$key];
			unset($this->map[$key]);
			return $ret;
		}
		return null;
	}
	
	/**
	 * Iterates over each value in the container passing them $predicate 
	 * If the $predicate function returns true, the current value 
	 * in the container is returned into the result array, keys are 
	 * preserved. 
	 * 
	 * @param Closure $predicate
	 * @return array | filtered elements
	 */
	public function filter(Closure $predicate)
	{
		return array_filter($this->map, $predicate);
	}

	/**
	 * Returns the value associated with $key.
	 * 
	 * @param mixed $key | integer or string
	 * @return mixed
	 */
	public function get($key)
	{
		return isset($this->map[$key]) ? $this->map[$key] : null;
	}

	/**
	 * Iterator.
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->map);
	}

	/**
	 * Returns whether the key isset or not in the container.
	 * 
	 * @param mixed $key | integer or string
	 * @return boolean
	 */
	public function has($key)
	{
		return isset($this->map[$key]);
	}

	/**
	 * Inserts a key and an associated value to the container.
	 * 
	 * @param mixed $key | integer or string
	 * @param mixed $value
	 * @return void
	 */
	public function insert($key, $value = null)
	{
		$this->map[$key] = $value;
	}

	/**
	 * Checks whether the container is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->map;
	}

	/**
	 * Returns all the container keys, since the map can have the
	 * same values more than ones, providing $value in the 
	 * argument will return the keys of the value.
	 *  
	 * @param mixed $value
	 * @return array
	 */
	public function keys($value = null)
	{
		return $value ? array_keys($this->map, $value, true) : array_keys($this->map);
	}
	
	/**
	 * Alias of has().
	 * 
	 * ArrayAccess interface.
	 * 
	 * @see has()
	 * @param mixed $offset | integer or string
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return $this->has($offset);
	}
	
	/**
	 * Alias of get().
	 * 
	 * ArrayAcces interface.
	 * 
	 * @see get()
	 * @param mixed $offset | integer or string
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}
	
	/**
	 * Sets an element at the specified offset.
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset | integer or string
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$offset ? $this->map[$offset] = $value : $this->map[] = $value;
	}
	
	/**
	 * Alias of erase().
	 * 
	 * ArrayAccess interface.
	 * 
	 * @see erase()
	 * @param mixed $offset | integer or string
	 * @return mixed | removed element or null if offset doesn't exist
	 */
	public function offsetUnset($offset)
	{
		return $this->erase($offset);
	}
	
	/**
	 * Adds $value to the end of container with an integer key.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		$this->map[] = $value;	
	}

	/**
	 * Removes value from the container, the container might have
	 * the same value more than once and this removes each 
	 * returning the number of removals.
	 * 
	 * @param mixed $value
	 * @return integer | number of removals
	 */
	public function remove($value)
	{
		$keys = $this->keys($value);
		foreach ($keys as $k)
		{
			unset($this->map[$k]);
		}
		return count($keys);
	}

	/**
	 * Returns the number of elements in the map container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->map);
	}
}
?>