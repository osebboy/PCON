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
namespace PCON\Interfaces;

use Closure;

/**
 * Container Interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
interface ContainerInterface extends Pcon
{
	/**
	 * Clears the list and removes all elements.
	 * 
	 * @return void
	 */
	public function clear();

	/**
	 * Provide a predicate and get filtered results in a new instance of the 
	 * corresponding container. Since the return value will always be a new instance 
	 * of the container, filtering can be chained.
	 * 
	 * <code>
	 * $list = new Liste();
	 * $filtered = $list->assign($array)
	 * 		    ->filter($func1)
	 * 		    ->merge($otherList)
	 * 		    ->filter($func2);
	 * 
	 * $filtered instanceof Liste; // true
	 * </code>
	 * 
	 * @param Closure $predicate
	 * @return $this
	 */
	public function filter(Closure $predicate);
	
	/**
	 * Tests whether the container is empty.
	 * 
	 * @return boolean
	 */
	public function isEmpty();

	/**
	 * Returns the number of elements.
	 * 
	 * @return integer
	 */
	public function size();

	/**
	 * Container to Array.
	 * 
	 * PHP array functions do not accept Iterator or IteratorAggregate 
	 * instances as the array argument. This isolates PCON containers from 
	 * the built in or user defined array functions. This method provides
	 * flexibility in adapting PCON containers into existing systems. 
	 * 
	 * While most of the iterators provide a method of obtaining the array
	 * copy (ArrayIterator::getArrayCopy() or SplFixedArray::toArray()...)
	 * it will require to create a new instance of the iterator, which is not
	 * desirable in all circumstances.
	 * 
	 * In contrast, this method is not in compliance with the theory of all 
	 * the data structures because it gives access to the keys and the container
	 * structure. Since this is implemented in the user-land instead of the PHP 
	 * language construct, it should be considered as a convenience method.
	 * 
	 * <code>
	 * $list = new Liste();
	 * $list->assign('cat', 'dog');
	 *  
	 * $arr = array_map( 
	 * 		function ($value) 
	 * 		{ 
	 * 			return strtoupper($value); 
	 * 		},
	 * 		$list->toArray();
	 * );
	 * 
	 * $arr === array( 'CAT', 'DOG' ); // true
	 * 
	 * // or create a new container with $arr and continue operations on it:
	 * 
	 * $set = new StringSet();
	 * $set->assign($arr)->erase('CAT');
	 * 
	 * $set->count('DOG'); // 1
	 * $set->count('CAT'); // 0
	 * </code>
	 * 
	 * @return array
	 */
	public function toArray();
}
