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
 * @version    2.0.alpha
 */
namespace PCON;

use PCON\Definitions\StdInterface;
use PCON\Traits\Base;
use PCON\Traits\KeyAccess;
use PCON\Traits\Modifiers;
use Closure, ArrayAccess, ArrayIterator;

/**
 * Map is a lightweight associative container that stores elements formed 
 * by the combination of a key value and a mapped value.
 * 
 * @trait Base
 * @trait KeyAccess 
 * @trait Modifiers 
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Map implements StdInterface, ArrayAccess
{
	/**
	 * Traits.
	 */
	use Base, KeyAccess, Modifiers;

	/**
	 * Iterator position.
	 * 
	 * @var mixed | int or string
	 */
	protected $pos = null;

	/**
	 * Searches the container for an element with $key.
	 * Since map container doesn't allow the same key again, it always returns
     * 0(zero) or 1(one). In contrast, MultiMap containers can return more than
     * 1 since MultiMaps allow more than 1 value for a key.
     *
	 * Alias of isset($this->container[$key]). The reason why "count($key)" used
	 * instead of other easily identifiable name is because this creates a 
	 * consistent API with MultiMap.
	 *
	 * @see PCON\MultiMap
	 * @param mixed $key
	 * @return integer | if key exists, then this returns 1, else 0(zero).
	 */
	public function count($key)
	{
		return (int) isset($this->container[$key]);
	}

	/**
	 * Iterates over each value in the container passing them $predicate 
	 * If the $predicate function returns true, the current value 
	 * in the container is returned into the result array, keys are 
	 * preserved. 
	 * 
	 * @param Closure $predicate
	 * @return Map | new instance with filtered elements
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
	 * Searches the map with a value and returns the key if found. There might be
     * more than one of the same value with a different key (which is very rare). 
	 * This returns the first key found.
	 *
	 * @param mixed $value
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
	 * @return Map | $this
	 */
	public function insert($key, $value)
	{
		$this->container[$key] = $value;
		
		return $this;
	}

	/**
	 * Get map keys as values in an array.
	 *
	 * @return array
	 */
	public function keys()
	{
		return array_keys($this->container);
	}

	/**
	 * Remove a value without looking at its key.
	 *
     * @param mixed $value
	 * @return boolean | true if removed, false otherwise
	 */
	public function remove($value)
	{
		return (boolean) $this->erase($this->indexOf($value));
	}
	
	/**
	 * Set the iterator starting position. Works with 'string' keys as well.
	 * If the key is string, then 'while' loop need to be used because 'foreach'
	 * will rewind the container before iteration.
	 *
	 * <code>
	 * $map = mew Map();
	 * $map['a'] = 1;
	 * $map['b'] = 2;
	 * $map['c'] = 3;
	 * $map['d'] = 4;
	 * $map['e'] = 5;
	 *
	 * $map->seek('c');
	 *
	 * $it = $map->getIterator(); // we call the iterator explicitly
	 *
	 * while ( $it->valid() )
	 * {
	 * 	  echo $it->current();
	 *
	 * 	  $it->next();
	 * }
	 * // returns 3 4 5 
	 * </code>
	 * 
	 * @see Map::getIterator()
	 * @param mixed $position | int or string
	 * @return Map | $this
	 */
	public function seek($position)
	{
		if ( !isset($this->container[$position]) )
		{
			throw new \InvalidArgumentException('Position does not exist');
		}
		$this->pos = $position;
		
		return $this;
	}

	/**
	 * Sorts the map in ascending order if a comparison function is not provided. With a
	 * comparison function, it sorts the map's values based on the function. 
	 * 
     * @param $comp | optional - Closure, function
	 * @return boolean | true if sorted, false otherwise 
	 */
	public function sort(Closure $comp = null)
	{
		return $comp ? uasort($this->container, $comp) : ksort($this->container);
	}
}
