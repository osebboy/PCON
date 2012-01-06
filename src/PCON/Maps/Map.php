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
	 * Searches the container for an element with $key.
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
	 * @return PCON\Maps\Map | with filtered elements
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

		if ( $this->pos )
		{
			if ( !isset($this->container[$this->pos]) )
			{
				throw new \LogicException('Invalid position');
			}
			if ( is_int($this->pos) )
			{
				$it->seek($this->pos);
				
				$this->pos = null;

				return $it;
			}
			while ( $it->valid() )
			{
				if ( $it->key() === $this->pos )
				{
					$this->pos = null;

					return $it;
				}
				$it->next();
			}
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
	 * Set the iterator starting position. Works with 'string' keys as well.
	 *
	 * PHP's SeekableIterator only works with integer values, unfortunately.
	 * Here, this method allows setting the iterator position to string keys as
	 * well. The important point to keep in mind is that if the iterator
	 * pointer is set with this method, then the iterator should be 
	 * called explicitly and 'while' loop should be used instead of 'foreach'
	 * because 'foreach' will rewind the iterator position to the beginning of
	 * the container before the iteration. See the example below.
	 *
	 * <code>
	 * $map = mew Map();
	 * $map['a'] = 1;
	 * $map['b'] = 2;
	 * $map['c'] = 3;
	 * $map['d'] = 4;
	 * $map['e'] = 5;
	 * 
	 * $map->seek('c'); // now the iterator points to the key 'c'
	 * 
	 * // if we do a foreach, it will start from the beginning
	 * foreach ( $map as $value )
	 * {
	 * 	echo $value;
	 * } 
	 * // returns 1 2 3 4 5
	 *
	 * // now see how it's with 'while'
	 * // iterator position is reset after every iteration in Maps
	 * // since we iterated previously, we need to set the iterator position again
	 * $map->seek('c');
	 * $it = $map->getIterator(); // we call the iterator explicitly
	 *
	 * // it will start  iteration from the key 'c' as we would expect using 'seek'
	 * while ( $it->valid() )
	 * {
	 * 	echo $it->current();
	 *
	 * 	$it->next();
	 * }
	 * // returns 3, 4, 5 
	 * </code>
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
	 * Sorts the map in ascending order if a comparison function is not provided. With a
	 * comparison function, it sorts the map's values based on the function. 
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
	 * $map->insert('tar', 'zip')->insert('foo', 'bar');
	 *
	 * var_dump($map->sort($comp)) ; // true(boolean)
	 *
	 * $map->toArray() === array('foo' => 'bar', 'tar' => 'zip'); // true
	 * </code>
	 * 
         * @param $comp | optional - Closure, function
	 * @return boolean | true if sorted, false otherwise 
	 */
	public function sort(Closure $comp = null)
	{
		return $comp ? uasort($this->container, $comp) : ksort($this->container);
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
