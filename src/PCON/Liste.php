<?php
/*
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
use PCON\Traits\Modifiers;
use PCON\Traits\ElementAccess;
use Closure;

/*
 * Liste (List) is a lighweight sequence container(FIFO), as such its elements 
 * are ordered following a linear sequence, a collection of values
 * which may occur more than once.
 * 
 * 'List' is a reserved name in PHP, so the name 'Liste' is adapted instead,
 * which means 'List' in German, Turkish and in some other languages.
 * 
 * @trait Base
 * @trait Modifiers 
 * @trait ElementAccess
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Liste implements StdInterface
{
	/*
	 * Traits.
	 */
	use Base, Modifiers, ElementAccess;
	
	/**
	 * Filter the list with a predicate and return filtered elements
	 * in a new list. 
	 *
	 * @param Closure $predicate | Closure must return boolean
	 * @return Liste | new instance
	 */
	public function filter(Closure $predicate)
	{
		return (new Liste)->assign(array_filter($this->container, $predicate));
	}

	/*
	 * Insert an element with a key. This is not a sorted list. sort() method
     * need to be called to achieve a sorted list.
	 *
	 * @param integer $key
     * @param mixed $value
     * @return List | $this
	 */
	public function insert($key, $value)
	{
		if ( !is_int($key) )
		{
			return trigger_error('Expects key to be an integer', E_USER_WARNING);
		}
		$this->container[$key] = $value;

		return $this;
	}
	
	/**
	 * Merge a different list to $this one.
	 *
	 * @param Liste
	 * @return Liste | $this
	 */
	public function merge(Liste $list)
	{
		$this->container = array_merge($this->container, $list->toArray());

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
	 * @param Closure $predicate | need to return boolean
	 * @return integer | number of removed elements 
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
	 * @param boolean $preserve_keys
	 * @return Liste | $this
	 */
	public function reverse($preserve_keys = true)
	{
		$this->container = array_reverse($this->container, $preserve_keys);

		return $this;
	}
	
	/**
	 * if $comp function is provided in the argument, then
	 * sorts the list depending on the function, else it
	 * sorts the list indices from lower to higher.
	 * 
	 * @param Closure $comp | compare function
	 * @return boolean | true if sorted, false othersise
	 */
	public function sort(Closure $comp = null)
	{
		return $comp ? uasort($this->container, $comp) : ksort($this->container);
	}

	/*
	 * Swap this list with another one.
     *
	 * @param Liste | another list
	 * @return Liste | $this
	 */
	public function swap(Liste $list)
	{
		$cp = $this->container;
		
		$this->container = $list->toArray();
		
		$list->assign($cp);
		
		unset($cp);

		return $this;
	}
	
	/**
	 * Returns the unique elements in a new list.
	 *
	 * @return Liste | a new instance
	 */
	public function unique()
	{
		$array = [];

		foreach ( $this->container as $key => $value )
		{
			if ( !in_array($value, $array, true) )
			{
				$array[$key] = $value;
			}
		}
		return (new Liste)->assign($array);
	}
}
