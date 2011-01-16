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

use Closure, IteratorAggregate, RecursiveArrayIterator;

/**
 * MultiMap is an associative container much like a Map container but allows
 * different elements to have the same key, see example below.
 * 
 * Most of the methods have examples right above them and the following 
 * object is used for the examples.
 * 
 * $map = new MultiMap();
 * $map['animals'] = 'cat';
 * $map['animals'] = 'cow';
 * $map['animals'] = 'dog';
 * $map['animals'] = 'fox';
 * $map['animals'] = 'ant';
 * 
 * So the container looks like:
 * 
 * MultiMap -> array { "animals" => array {
 *     									0 => "cat",
 *     									1 => "cow",
 *     									2 => "dog",
 *     									3 => "fox",
 *     									4 => "ant"
 * }
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class MultiMap implements MapInterface, IteratorAggregate
{
	/**
	 * Key iterator position.
	 * 
	 * @see setIteratorPosition()
	 * @var mixed
	 */
	protected $pos = null;
	
	/**
	 * Multi map container.
	 * 
	 * @var array
	 */
	protected $map = array();
	
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
	 * Returns the number of elements associated with
	 * a key.
	 * 
	 * $map->count('animals') // returns 5
	 * 
	 * @param mixed $key | string or integer
	 * @return integer
	 */
	public function count($key)
	{
		return count($this->get($key));
	}
	
	/**
	 * Erases the key and all the elements associated with it.
	 * 
	 * $map->erase('animals');
	 * $map->has('animals') // returns false
	 * 
	 * @param mixed $key | integer or string
	 * @return array | removed value or null is $key doesn't exists
	 */
	public function erase($key)
	{
		if (isset($this->map[$key]))
		{
			$ret = $this->map[$key];
			unset($this->map[$key]);
			return $ret;
		}
		return array();
	}
	
	/**
	 * Iterates over each value associated with $key passing 
	 * them $predicate, if the $predicate returns true, the current
	 * value in the container is added to the result array,
	 * keys are preserved. 
	 * 
	 * // predicate, a trivial example
	 * 
	 * $p = function($value) 
	 * {
	 * 		// return all values with letter 'o' in it
	 * 		return stripos($value, 'o') !== false; 			
	 * };
	 * 
	 * $map->filter('animals', $p);
	 * 
	 * // returns
	 * array(1 => 'cow', 2 => 'dog', 3 => 'fox');
	 * 
	 * @param Closure $predicate
	 * @param mixed | integer or string (depth 1)
	 * @return array | filtered elements
	 */
	public function filter($key, Closure $predicate)
	{
		return array_filter($this->get($key), $predicate);
	}
	
	/**
	 * Returns value (depth 2) associated with a key(depth 1)
	 * 
	 * $map->get('animals'); // returns the animals array
	 * 
	 * @param mixed $key | integer or string
	 * @return array
	 */
	public function get($key)
	{
		return isset($this->map[$key]) ? $this->map[$key] : array();
	}
	
	/**
	 * Iterator, setIteratorPosition($key) method moves the iterator
	 * to the specified $key on demand which is useful if a certain
	 * part of the multi map needs to be iterated.
	 * 
	 * @see setIteratorPosition()
	 * @return RecursiveArrayIterator
	 */
	public function getIterator()
	{
		return new RecursiveArrayIterator($this->pos ? $this->get($this->pos) : $this->map);
	}
	
	/**
	 * Gets the MultiMap container's key iterator position.
	 * 
	 * @see setIteratorPosition()
	 * @return mixed | null if position isn't set
	 */
	public function getIteratorPosition()
	{
		return $this->pos;
	}

	/**
	 * Checks whether a key is set.
	 * 
	 * @param mixed $key | integer or string
	 * @return boolean
	 */
	public function has($key)
	{
		return isset($this->map[$key]);
	}
	
	/**
	 * Inserts key and value, multimap accepts more than 1 value
	 * for the same key, see the class definition above.
	 * 
	 * @param mixed $key | integer or string
	 * @param mixed $value
	 * @return void
	 */
	public function insert($key, $value)
	{
		$this->map[$key][] = $value;
	}
	
	/**
	 * Returns whether the container is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->map;
	}
	
	/**
	 * Returns all the keys of the map.
	 * 
	 * @return array
	 */
	public function keys()
	{
		return array_keys($this->map);
	}
	
	/**
	 * Alias of has().
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset
	 */
	public function offsetExists($offset)
	{
		return $this->has($offset);
	}
	
	/**
	 * Alias of get().
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}
	
	/**
	 * Alias of insert(), returns Notice if offset is missing
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		$offset ? $this->map[$offset][] = $value : trigger_error('Missing index');
	}
	
	/**
	 * Alias of erase().
	 * 
	 * ArrayAccess interface.
	 * 
	 * @param mixed $offset
	 * @return array | removed array
	 */
	public function offsetUnset($offset)
	{
		return $this->erase($offset);
	}

	/**
	 * Removes value(might have more than once) under a key and
	 * returns the count of removals. 
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * @return integer | number of $value removed
	 */
	public function remove($key, $value)
	{
		$count = 0;
		foreach ($this->get($key) as $k => $v)
		{
			if ($v === $value)
			{
				unset($this->map[$key][$k]);
				++$count;
			}
		}
		return $count;
	}

	/**
	 * Resets the MultiMap container's key iterator position.
	 * 
	 * @see setIteratorPosition($key)
	 * @return void
	 */
	public function resetIteratorPosition()
	{
		$this->pos = null;
	}
	
	/**
	 * Sets the MultiMap container's key iterator position.
	 * Useful when you want to iterate under a certain a key
	 * position.
	 * 
	 * // After the following, the iterator will only include the
	 * // array under the position specified
	 * 
	 * $map->setIteratorPosition('animals'); 
	 * 
	 * foreach ($map as $val)
	 * {
	 * 		echo $val;
	 * }
	 * 
	 * //returns
	 * cat cow dog fox ant
	 * 
	 * $map->getIteratorPosition(); // returns 'animals'
	 * 
	 * $map->resetIteratorPosition(); // reset position
	 * 
	 * $map->getIteratorPosition(); // now returns null
	 * 
	 * @param mixed $key | integer or string
	 * @return void
	 */
	public function setIteratorPosition($key)
	{
		$this->pos = $key;	
	}

	/**
	 * Returns the number of keys in the container, not all
	 * the elements in multimap, 
	 * 
	 * @see count($key)
	 * @return integer
	 */
	public function size()
	{
		return count($this->map);
	}
}
?>