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
namespace PCON\Sets;

use PCON\Interfaces\SetInterface;
use PCON\Interfaces\ContainerInterface;
use Closure, SplFixedArray;

/**
 * Object Set is a lightweight associative container that stores unique objects.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class ObjectSet implements SetInterface
{
	/**
	 * Object set container.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Assign objects to the set.
	 * 
	 * @see insert()
	 * @param  array $array
	 * @return ObjectSet | $this
	 */
	public function assign($args)
	{
		$args = is_array($args) ? $args : ($args instanceof ContainerInterface ? $args->toArray() : func_get_args());
		
		$this->clear();
		
		foreach ( $args as $k => $v )
		{
			$this->insert($v);
		}
		return $this;
	}
	
	/**
	 * Clears the container and removes all objects.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->container = array();
	}
	
	/**
	 * Tests whether object is in the container,
	 * 
	 * @param  object $value 
	 * @return boolean
	 */
	public function count($value)
	{
		return (int) isset($this->container[spl_object_hash($value)]);
	}
	
	/**
	 * Erase a value.
	 *
         * @param object
	 * @return boolean | true if removed, false otherwise
	 */
	public function erase($value)
	{
		$h = spl_object_hash($value);
		
		if ( isset($this->container[$h]) )
		{
			unset($this->container[$h]);
			
			return true;
		}
		return false;
	}

	/**
	 * Filter the set with the given predicate.
	 * 
	 * @param  Closure $predicate
	 * @return array
	 */
	public function filter(Closure $predicate)
	{
		$set = new ObjectSet();
		
		return $set->assign(array_filter($this->container, $predicate));
	}
	
	/**
	 * Iterator.
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_values($this->container));
	}
	
	/**
	 * Inserts an object to the se.
	 * 
	 * @throws E_USER_WARNING if $value is not an object
	 * @param  object $value
	 * @return void
	 */
	public function insert($value)
	{
		if ( !is_object($value) )
		{
			return trigger_error('ObjectSet expects value to be object', E_USER_WARNING);
		}
		$this->container[spl_object_hash($value)] = $value;

		return $this;
	}

	/**
	 * Checks to see if set is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}

	/**
	 * Size of the container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}

	/**
	 * 
	 */
	public function sort(Closure $comp)
	{
		return uasort($comp, $this->container);
	}
	
	/**
	 * Set to array.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->container;
	}
}
