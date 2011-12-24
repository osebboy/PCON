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
use Closure, SplFixedArray;

/**
 * SetAbstract contains the common Set members. This eventually might be replaced
 * with a Trait after the PHP 5.4 release.
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
abstract class SetAbstract implements SetInterface
{
	/**
	 * Container.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Assign an array of elements with key => $value pairs or provide arguments.
	 * Clears all the elements prior to adding the new elements.
	 * 
	 * <code>
	 * $set = new StringSet();
	 *
	 * // values as arguments
	 * $set->assign( 'cat', 'dog' );
	 * 
	 * // or an array
	 * $set->assign( array(0 => 'cat', 1 => 'dog') );
	 *
	 * // or another container
	 * $set->assign( $set2 ); 
	 * 
	 * // returns itself for chaining
	 * $set->assign('cat', 'dog')->filter($somefunction);
	 * </code>
	 *
	 * @see insert()
	 * @param  mixed | $args
	 * @return $this
	 */
	public function assign($args)
	{		
		$args = is_array($args) ? $args : ($args instanceof \PCON\Interfaces\ContainerInterface ? $args->toArray() : func_get_args());

		$this->clear();
		
		foreach ( $args as $v )
		{
			$this->insert($v);
		}
		return $this;
	}
	
	/**
	 * Clears the container and removes all elements.
	 * 
	 * @return $this
	 */
	public function clear()
	{
		$this->container = array();
	}
	
	/**
	 * Tests whether an element exists in the container. This method will
	 * always either return 1 if element exists, 0(zero) otherwise.
	 * 
	 * @param  Set specific type
	 * @return integer
	 */
	public function count($value)
	{
		return (int) isset($this->container[$this->hash($value)]);
	}
	
	/**
	 * Erase an element.
	 *
         * @param  Set specific type
	 * @return boolean | true if removed, false otherwise
	 */
	public function erase($value)
	{
		$h = $this->hash($value);
		
		if ( isset($this->container[$h]) )
		{
			unset($this->container[$h]);
			
			return true;
		}
		return false;
	}

	/**
	 * Filter the set with a predicate.
	 * 
	 * @param  Closure $predicate
	 * @return PCON\Interfaces\SetInterface instance
	 */
	public function filter(Closure $predicate)
	{
		$set = new static();
		
		return $set->assign(array_filter($this->container, $predicate));
	}
	
	/**
	 * Iterator.
	 * 
	 * @return SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_values($this->container));
	}
	
	/**
	 * Inserts an element to the set.
	 * 
	 * @param  Set specific type
	 * @return $this
	 */
	public function insert($value)
	{
		if ( !$this->isValid($value) )
		{
			return trigger_error('Invalid type', E_USER_WARNING);
		}
		$this->container[$this->hash($value)] = $value;

		return $this;
	}

	/**
	 * Checks to see if the container is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}

	/**
	 * Number of elements in the container.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}

	/**
	 * Sort the container with compare function. 
	 *
	 * @param Closure $comp | compare function
	 * @return boolean | true if sorted, false otherwise
	 */
	public function sort(Closure $comp)
	{
		return uasort($this->container, $comp);
	}
	
	/**
	 * To array.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->container;
	}

	/**
	 * Returns the hash of value.
	 * 
	 * @param  Set specific type
	 * @return string
	 */
	abstract protected function hash($value);

	/**
	 * Tests whether the value is a valid type for the set.
	 *
	 * @param  Set specific type
	 * @return boolean
	 */
	abstract protected function isValid($value);

}
