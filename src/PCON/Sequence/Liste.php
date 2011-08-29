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
 * @package    PCON\Sequence
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sequence;

use Closure, ArrayIterator;

/**
 * Liste (List) is a lighweight sequence container(FIFO), as such its elements 
 * are ordered following a linear sequence, an ordered collection of values
 * which may occur more than once.
 * 
 * 'List' is a reserved name in PHP, so the name 'Liste' is adapted instead,
 * which means 'List'in German, Turkish and in some other languages.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class Liste implements ListInterface
{
	/**
	 * List container.
	 * 
	 * @var array
	 */
	protected $list = array();
	
	/**
	 * Assign an array to the container, which tests the 
	 * array keys for integer values by default and can be
	 * declared false to disable if the incoming indices
	 * are known to be integers already but not validating
	 * is not recommended.
	 * 
	 * @param  array $array
	 * @param  bool  $validate
	 * @return void
	 */
	public function assign(array $array, $validate = true)
	{
		if ($validate)
		{
			foreach ($array as $k => $v)
			{
				$this->insert($k, $v);
			}
		}
            else
            {
		$this->list = $array;
            }
	}
	
	/**
	 * Returns the element from the end of the list.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->list);
	}
	
	/**
	 * Clears the list and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->list = array();
	}

	/**
	 * Deletes an element from the list by index.
	 * 
	 * @param integer $index
	 * @return mixed | removed value, null if none removed
	 */
	public function erase($index)
	{
		if (isset($this->list[$index])) 
		{ 
			$ret = $this->list[$index];
			unset($this->list[$index]);
			return $ret; 
		}
		return null;
	}
	
	/**
	 * Returns an element from the beginning of the list.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->list);
	}

	/**
	 * Iterator
	 * 
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->list);
	}
	
	/**
	 * Inserts an element with the given index, the keys are
	 * not sorted, sort() method should be called to sort the
	 * list after insert.
	 * 
	 * @param integer $index
	 * @param mixed $value
	 * @return void
	 */
	public function insert($index, $value)
	{
		if ( !is_int($index) ) { return trigger_error('Invalid index', E_USER_WARNING); }
		$this->list[$index] = $value; 
	}

	/**
	 * Tests whether the list is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->list;
	}

	/**
	 * Removes an element from the end of the list.
	 * 
	 * @return mixed | removed element
	 */
	public function pop_back()
	{
		return array_pop($this->list);
	}

	/**
	 * Removes an element from the beginning of the list.
	 * 
	 * @return mixed | removed element
	 */
	public function pop_front()
	{
		return array_shift($this->list);
	}
	
	/**
	 * Adds an element to the end of the list.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		$this->list[] = $value;
	}

	/**
	 * Adds a value to the beginning of the list.
	 * 
	 * @param mixed $value
	 * @return integer | the new number of elements in the list
	 */
	public function push_front($value)
	{
		return array_unshift($this->list, $value);
	}

	/**
	 * Removes value from the list, the same value may occur more
	 * than once so each one of them is removed and the number of
	 * removals is returned.
	 * 
	 * @param mixed $value
	 * @return integer | number of removals
	 */
	public function remove($value)
	{
		$keys = array_keys($this->list, $value, true);
		foreach ($keys as $key)
		{
			unset($this->list[$key]);
		}
		return count($keys);
	}

	/**
	 * Reverses the order of the elements in the list container,
	 * All the index references remain valid.
	 * 
	 * @return void
	 */
	public function reverse()
	{
		$this->list = array_reverse($this->list, true);
	}

	/**
	 * Returns the number of elements in the container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return (int) count($this->list);
	}
	
	/**
	 * if $comp function is provided in the argument, then
	 * sorts the list depending on the function, else it
	 * sorts the list indices from lower to higher.
	 * 
	 * @return boolean | true if sorted, false othersise
	 */
	public function sort(Closure $comp = null)
	{
		return $comp ? usort($this->list, $comp) : ksort($this->list);
	}
}
