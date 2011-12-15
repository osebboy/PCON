<?php
/**
 * PCON: PHP Containers.
 * 
 * Copyright (c) 2011 - 2012, Omercan Sebboy <osebboy@gmail.com>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE file 
 * that was distributed with this source code.
 *
 * @author     Omercan Sebboy (www.osebboy.com)
 * @copyright  Copyright(c) 2011 - 2012, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.1
 */
namespace PCON\Maps;

use PCON\Interfaces\MapInterface;
use Closure, ArrayIterator;

/**
 * Map is a lightweight associative container that stores elements formed 
 * by the combination of a key value and a mapped value.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Map implements MapInterface
{
	/**
	 * Map container.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Iterator position.
	 * 
	 * @var mixed | int or string
	 */
	protected $pos = null;

	/**
	 * Clears the container and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->container = array();
	}

	/**
	 * Searches the container for an element with $key. Maps do not allow
         * Since map container doesn't allow the same key again, it always returns
         * 0(zero) or 1(one). In contrast, MultiMap containers can return more than
         * 1 since MultiMaps allow more than 1 value for a key.
         *
	 * @see PCON\Maps\MultiMap
	 * @return integer  
	 */
	public function count($key)
	{
		return (int) isset($this->container[$key]);
	}

	/**
	 * Erases the key and its value.
	 * 
	 * @param mixed $key | integer or string
	 * @return mixed | removed value or null if $key doesn't exists
	 */
	public function erase($key)
	{
		$ret = null;

		if ( isset($this->container[$key]) )
		{
			$ret = $this->container[$key];

			unset($this->container[$key]);
		}
		return $ret;
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
		$map = new Map();
		
		foreach ( array_filter($this->container, $predicate) as $k => $v )
		{
			$map->insert($k, $v);
		}
		return $map;
	}

	/**
	 * Iterator.
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		$it = new ArrayIterator($this->container);
		
		// need to check again if position still exists
		// because seek() can be called and the key can be erased before the iterator
		if ( $this->pos )
		{
			if ( !isset($this->container[$this->pos]) )
			{
				throw new \LogicException('Invalid position');
			}
			$it->seek($this->pos);
			
			$this->pos = null; // reset the position
		}
		return $it;
	}

	/**
	 * Searches the map with a value and returns the key if found. There might
         * more than one of the same value. This returns the first key found.
	 *
	 * @param mixed
	 * @return mixed | associated key with the value, false otherwise
	 */
	public function indexOf($value)
	{
		return array_search($value, $this->container, true);
	}

	/**
	 * Inserts a key and an associated value to the container.
	 * 
	 * @param mixed $key | integer or string
	 * @param mixed $value
	 * @return void
	 */
	public function insert($key, $value)
	{
		$this->container[$key] = $value;
		
		return $this;
	}

	/**
	 * Checks whether the container is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}
	
	/**
	 * Tests if offset exists.
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset | integer or string
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return isset($this->container[$offset]);
	}
	
	/**
	 * Get an element at an offset.
	 * 
	 * ArrayAcces interface.
	 * 
	 * @param mixed $offset | integer or string
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
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
		$offset ? $this->container[$offset] = $value : $this->container[] = $value;
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
	 * Remove a value without looking at its key.
	 *
         * @param mixed
	 * @return boolean | true if removed, false otherwise
	 */
	public function remove($value)
	{
		return (boolean) $this->erase($this->indexOf($value));
	}
	
	/**
	 * Set the iterator starting position. The position is reset to
	 * null after iteration.
	 * 
	 * @see Map::getIterator()
	 * @param Mixed |int or string
	 * @return Map | $this
	 */
	public function seek($position)
	{
		if ( !isset($this->container[$position]) )
		{
			throw new \InvalidArgumentException('Key does not exist');
		}
		$this->pos = $position;
		
		return $this;
	}

	/**
	 * Sorts the map with a Comparison function. Key => Value relation is preserved.
	 *
	 * <code>
	 * $comp = function ($a, $b) 
	 * {
    	 * 	if ($a == $b) 
	 * 	{
         * 		return 0;
    	 * 	}
    	 * 	return ($a < $b) ? -1 : 1;
	 * };
	 * $map = new Map();
	 * $map->assign( array('tar' => 'zip', 'foo' => 'bar') );
	 * var_dump($map->sort($comp)) ; // true(boolean)
	 *
	 * $map->toArray() === array('foo' => 'bar', 'tar' => 'zip'); // true
	 * </code>
	 *
	 * @param $comp | Closure, function
	 * @return boolean | true if sorted, false otherwise
	 */
	public function sort(Closure $comp)
	{
		return uasort($comp, $this->container);
	}

	/**
	 * Returns the number of elements in the map container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}

	/**
	 * Return map in an array.
	 *
	 * @see PCON\Interfaces\ContainerInterface
	 * @return array 
	 */
	public function toArray()
	{
		return $this->container;
	}
}
