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
 * @version    1.0
 */
namespace PCON\Interfaces;

use Closure;

/**
 * Container Interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
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
	 * Provide a predicate and get filtered results in a new 
	 * instance of the corresponding container. Since the
	 * return value will always be a new instance of the
	 * container, filtering can be chained.
	 * 
	 * Example:
	 * $list = new Liste();
	 * $filtered = $list->assign($array)
	 * 		    ->filter($func1)
	 * 		    ->merge($otherList)
	 * 		    ->filter($func2);
	 * 
	 * $filtered instanceof Liste === true
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
	 * PHP array functions (which is called Operations or Algorithms)
	 * do not accept Iterator or IteratorAggregate instances as
	 * the array argument. This isolates PCON containers from the 
	 * built in or user defined array functions. This method provides
	 * flexibility in adapting these containers into existing 
	 * systems. While most of the iterators provide a mehtod of obtaining
	 * the array copy, it will require to create a new instance of the
	 * iterator, which is not desirable in all circumstances.
	 *  
	 * Example:
	 * $list = new Liste();
	 * $list->assign('cat', 'doggie', 'cow');
	 *  
	 * $arr = array_filter(
	 * 			$liste->toArray(), 
	 * 			function ($v) 
	 * 			{ 
	 * 				return strlen($v) === 3; 
	 * 			}
	 * );
	 * 
	 * $arr === array( 'cat', 'cow' ) // true
	 * 
	 * Or...
	 * 
	 * $list2 = new Liste();
	 * $list2->assign(array_filter($list->toArray(), $your_function));
	 */
	public function toArray();
}
