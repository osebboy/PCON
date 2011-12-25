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
namespace PCON\Sequence;

use PCON\Interfaces\ListInterface;
use Closure, ArrayIterator;

/**
 * Liste (List) is a lighweight sequence container(FIFO), as such its elements 
 * are ordered following a linear sequence, a collection of values
 * which may occur more than once.
 * 
 * 'List' is a reserved name in PHP, so the name 'Liste' is adapted instead,
 * which means 'List'in German, Turkish and in some other languages.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Liste implements ListInterface
{
	/**
	 * List container.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Assign an array of elements with key => $value pairs
	 * or provide arguments.
	 * 
	 * <code>
	 * $list = new Liste();
	 *
	 * // values as arguments
	 * $list->assign( 'cat', 'dog' );
	 * 
	 * // or an array
	 * $list->assign( array(0 => 'cat', 1 => 'dog') );
	 *
	 * // or another container
	 * $list->assign( $list2 ); 
	 * 
	 * // returns itself for chaining
	 * $list->assign('cat', 'dog')->filter($somefunction);
	 * </code>
	 *
	 * @param mixed $args
	 * @return $this
	 */
	public function assign($args)
	{
		$args = is_array($args) ? $args : ($args instanceof \PCON\Interfaces\ContainerInterface ? $args->toArray() : func_get_args());
		
		$this->clear();
		
		foreach ( $args as $k => $v )
		{
			$this->insert($k, $v);
		}
		return $this;
	}
	
	/**
	 * Returns the element from the end of the list.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->container);
	}
	
	/**
	 * Clears the list and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->container = array();
	}

	/**
	 * Deletes an element from the list by index.
	 * 
	 * @param integer $index
	 * @return mixed | removed value, null if none removed
	 */
	public function erase($index)
	{
		$ret = null;

		if ( isset($this->container[$index]) ) 
		{ 
			$ret = $this->container[$index];

			unset($this->container[$index]);
		}
		return $ret;
	}

	/**
	 * Filter the list with a predicate and return filtered elements
	 * in a new list. 
	 *
	 * @param $predicate | an instance of Closure returning true, or false
	 * @return Liste
	 */
	public function filter(Closure $predicate)
	{
		$list = new Liste();
		
		return $list->assign(array_filter($this->container, $predicate));
	}
	
	/**
	 * Returns an element from the beginning of the list.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->container);
	}

	/**
	 * Iterator
	 * 
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->container);
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
		if ( !is_int($index) ) 
		{ 
			return trigger_error('List expects index to be an integer', E_USER_WARNING); 
		}
		$this->container[$index] = $value; 
	
		return $this;
	}

	/**
	 * Tests whether the list is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}

	/**
	 * Merge a different list to $this one.
	 *
	 * @return Liste 
	 */
	public function merge(ListInterface $liste)
	{
		$this->container = array_merge($this->container, $liste->toArray());

		return $this;
	}

	/**
	 * Removes an element from the end of the list.
	 * 
	 * @return mixed | removed element
	 */
	public function pop_back()
	{
		return array_pop($this->container);
	}

	/**
	 * Removes an element from the beginning of the list.
	 * 
	 * @return mixed | removed element
	 */
	public function pop_front()
	{
		return array_shift($this->container);
	}
	
	/**
	 * Adds an element to the end of the list.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		return array_push($this->container, $value);
	}

	/**
	 * Adds a value to the beginning of the list.
	 * 
	 * @param mixed $value
	 * @return integer | the new number of elements in the list
	 */
	public function push_front($value)
	{
		return array_unshift($this->container, $value);
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
		return $this->remove_if( function ($v) use($value) { return $v === $value; } );
	}

	/**
	 * Remove the elements if satisfies the predicate.
	 *
	 * @return int | number of removed elements 
	 */
	public function remove_if(Closure $predicate)
	{
		$found = array_filter($this->container, $predicate);
	
		foreach ( array_keys($found) as $key )
		{
			unset($this->container[$key]);
		}
		return count($found);
	}

	/**
	 * Reverses the order of the elements in the list container,
	 * All the index references remain valid.
	 * 
	 * @return Liste | $this
	 */
	public function reverse($preserve_keys = true)
	{
		$this->container = array_reverse($this->container, $preserve_keys);

		return $this;
	}

	/**
	 * Returns the number of elements in the container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
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
		return $comp ? uasort($this->container, $comp) : ksort($this->container);
	}

	/**
	 * Return list in an array.
	 *
	 * @see PCON\Interfaces\ContainerInterface
	 * @return array 
	 */
	public function toArray()
	{
		return $this->container;
	}

	/**
	 * Returns the unique elements in a new list.
	 *
	 * @return Liste 
	 */
	public function unique()
	{
		$array = array();

		foreach ( $this->container as $key => $value )
		{
			if ( !in_array($value, $array, true) )
			{
				$array[$key] = $value;
			}
		}
		$list = new Liste();
		
		return $list->assign($array);
	}
}
