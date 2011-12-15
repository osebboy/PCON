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

use Closure, ArrayIterator;

/**
 * MultiMap is an associative container much like a Map container but allows
 * different elements to have the same key, see example below.
 * 
 * Most of the methods have examples right above them and the following 
 * object is used for the examples.
 * 
 * <code>
 * $multimap = new MultiMap();
 * $multimap['animals'] = 'cat';
 * $multimap['animals'] = 'cow';
 * $multimap['animals'] = 'dog';
 * $multimap['animals'] = 'fox';
 * $multimap['animals'] = 'ant';
 * </code>
 * 
 * So the container looks like: 
 * array ( "animals" => array (
 *     			  0 => "cat",
 *     			  1 => "cow",
 *     			  2 => "dog",
 *     			  3 => "fox",
 *     			  4 => "ant" )
 * )
 * 
 * <code>
 * // we can position to 'animals'
 * $multimap->seek('animals');
 * 
 * // iterator will return the animals
 * // cat - cow - dog - fox - ant
 * foreach ( $multimap as $animal )
 * {
 * 		echo $animal . ' - ';
 * }
 * </code>
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class MultiMap extends Map
{	
	/**
	 * Returns the element count for a key.
	 * 
	 * <code>
	 * $map->count('animals'); // 5
         * </code>
	 *
	 * @param mixed $key | integer or string
	 * @return integer  
	 */
	public function count($key)
	{
		return count($this->offsetGet($key));
	}
	
	/**
	 * Iterates over each value associated with $key passing 
	 * them $predicate, if the $predicate returns true, the current
	 * value in the container is added to the result.
	 * 
	 * <code> 
	 * $predicate = function($value) 
	 * {
	 * 		// return all values with letter 'o' in it
	 * 		return stripos($value, 'o') !== false; 			
	 * };
	 * 
	 * // returns a new MultiMap with key 'animals' and values in Map ('cow', 'dog', 'fox')
	 * $map->filter($predicate); 
	 * </code>
	 * 
	 * @param Closure $predicate
	 * @param mixed | integer or string (depth 1)
	 * @return MultiMap with filtered elements
	 */
	public function filter(Closure $predicate)
	{
		$filtered = new MultiMap();
		
		foreach ( $this->container as $key => $array )
		{
			foreach ( $array as $value )
			{
				if ( $predicate($value) )
				{
					$filtered->insert($key, $value);
				}
			}
		}
		return $filtered;
	}
	
	/**
	 * Iterator.
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		$it = null;
		
		// need to check again if position still exists
		// the key can be erased before the iterator even if the position exists
		if ( $this->pos )
		{
			if ( !isset($this->container[$this->pos]) )
			{
				throw new \LogicException('Invalid position');
			}
			$it = new ArrayIterator($this->container[$this->pos]);
			
			$this->pos = null; // reset the position
		}
		else
		{
			$it = new ArrayIterator($this->container);
		}
		return $it;
	}

	/**
	 * Searches the multimap with a value and returns the key if found. There might
         * more than one of the same value. This returns the first key found.
	 *
	 * <code>
	 * $map->indexOf('cat'); // returns 'animals'
	 * </code>
	 *
	 * @param mixed
	 * @return mixed | associated key with the value, false otherwise
	 */
	public function indexOf($value)
	{
		foreach ( $this->container as $key => $array )
		{
			if ( in_array($value, $array, true) )
			{
				return $key;
			}
		}
		return false;
	}

	
	/**
	 * Inserts key and value, multimap accepts more than 1 value
	 * for the same key, see the class definition above.
	 * 
	 * @param mixed $key | integer or string
	 * @param mixed $value
	 * @return MultiMap | $this
	 */
	public function insert($key, $value)
	{
		$this->container[$key][] = $value;
		
		return $this;
	}
	
	/**
	 * Alias of insert(). Unlike Maps, $offset has to be provided for MultiMaps.
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->insert($offset, $value);
	}

	/**
	 * Removes a value associated with a key. 
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * @return mixed | false if not found
	 */
	public function remove($value)
	{
		foreach ( $this->container as $key => $array )
		{
			if ( ($id = array_search($value, $array, true)) !== false )
			{
				unset($this->container[$key][$id]);
				
				return $key;
			}
		}
		return false;
	}
}
