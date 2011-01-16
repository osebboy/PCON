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
 * @package    PCON\Sets
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sets;

use IteratorAggregate, Closure;

/**
 * Sets are a kind of associative containers that store unique elements.
 * 
 * PCON\Sets operates on the element hash values which enables to validate the
 * unique characteristic of an element. Currently there are two main sets in
 * PCON\Sets: ObjectSet and StringSet, which are very leightweight, simple and
 * extremely flexible.
 * 
 * SetInterface presents the base for Set objects and can be implemented to 
 * create unique set classes. The important thing to remember that the elements
 * have to be hashed to store uniquely. The other way is to check each element
 * in the set to test the uniqueness of an element but this leads to 0(n)
 * complexity and should not be implemented, in that, contains() method should
 * be avoided to check if the element exists in the set or not because insert()
 * method performs hashing.
 * 
 * @see PCON\Sets\ObjectSet
 * @see PCON\Sets\StringSet
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
interface SetInterface extends IteratorAggregate
{
	// modifiers
	public function build(array $array);
	public function clear();
	public function insert($value);
	public function remove($value);
	
	// operations
	public function find(Closure $predicate);
	public function toArray();
	public function contains($value);
	
	//capacity
	public function isEmpty();
	public function size();	
}