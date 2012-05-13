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
use SplFixedArray, Closure;

/**
 * Set is an associative container that stores unique elements. The elements are 
 * the keys themselves. 
 * 
 * @trait Base
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Set implements StdInterface
{
	/**
	 * Trait.
	 */
	use Base;
	
	/**
	 * Fill the container. This method offers 3 different ways to assign values
	 * to a set Returns itself for chanining.
	 *
	 * // array
	 * $set1 = (new Set)->assign(array(foo', 'bar'));
	 * 
	 * // arguments
	 * $set2 = (new Set)->assign('foo', 'bar', 'baz', 'bat');
	 * 
	 * // another PCON container
	 * $set3 = (new Set)->assign($set1);
	 * 
	 * @param mixed $arg
	 * @return Set | $this
	 */
	public function assign($arg)
	{
		$arg = func_get_args();
		
		if ( count($arg) == 1 )
		{
			$arg = is_array($arg[0]) ? $arg[0] : ( $arg[0] instanceof StdInterface ? $arg[0]->toArray() : $arg);
		}
		$this->container = [];
		
		foreach ( $arg as $val )
		{
			$this->insert($val);
		}
		return $this;
	}
	
	/**
	 * Tests if the set contains $value.
	 *
     * @param mixed $value
	 * @return boolean
	 */
	public function contains($value)
	{
		return in_array($value, $this->container, true);
	}
	
	/**
	 * Gets the difference between two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | difference
	 */
	public static function difference(Set $set1, Set $set2)
	{
		$diff1 = array_diff_key($set1->toArray(), $set2->toArray());
		
       	$diff2 = array_diff_key($set2->toArray(), $set1->toArray());

        return $diff1 + $diff2;
	}
	
	/**
	 * Erase a value from the set.
	 *
     * @param mixed $value
	 * @return boolean | true if removed, false otherwise
	 */
	public function erase($value)
	{
		$h = array_search($value, $this->container, true);
		
		if ( $h !== false )
		{
			unset($this->container[$h]);

			return true;
		}
		return false;
	}
	
	/**
	 * Filter the set with a predicate function. 
	 *
     * @param Closure $predicate
	 * @return Set | new instance with filtered elements
	 */
	public function filter(Closure $predicate)
	{	
		return (new Set)->assign(array_filter($this->container, $predicate));
	}
	
	/**
	 * Array values are returned in SplFixedArray.
	 *
	 * @return SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_values($this->container));
	}

	/**
	 * Insert a value. Set stores its hash as its key making it possible
     * for Set specific operations (difference, intersection, subtract,
     * union)
	 *
	 * @param mixed $value
	 * @return Set | $this
	 */
	public function insert($value)
	{
		if ( is_object($value) )
		{
			$this->container[spl_object_hash($value)] = $value;
		}
		else if ( is_array($value) )
		{
			$this->container[md5(serialize($value))] = $value;
		}
		else
		{
			$this->container[md5($value)] = $value;
		}
		return $this;
	}
	
	/**
	 * Returns the intersection between two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | intersection
	 */
	public static function intersection(Set $set1, Set $set2)
	{
		return array_intersect_key($set1->toArray(), $set2->toArray());
	}
	
	/**
	 * Sort the set values with a Compare function.
	 *
     * @param Closure $comp | compare function
	 * @return boolean | true if sorted, false otherwise
	 */
	public function sort(Closure $comp)
	{
		return uasort($this->container, $comp);
	}
	
	/**
	 * Subtracts the elements in $set2 from $set1.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | subtracted values
	 */
	public static function subtract(Set $set1, Set $set2)
	{
		return array_diff_key($set1->toArray(), $set2->toArray());
	}

	/**
	 * Gets the union of two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array
	 */
	public static function union(Set $set1, Set $set2)
	{
		return $set1->toArray() + $set2->toArray();
	}
}
