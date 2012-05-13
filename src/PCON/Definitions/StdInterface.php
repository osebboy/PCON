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
namespace PCON\Definitions;

use IteratorAggregate;

/*
 * Standard Interface that is implemented by all containers except for the
 * adaptors.  
 * 
 * PCON classes do not implement the Iterator interface due to its slow 
 * performance. Instead, IteratorAggregate is implemented. This approach provided
 * separation of concerns and faster iteration using built-in iterators. 
 * SplFixedArray and ArrayIterator are default iterators. MultiMap uses the
 * MultiMapIterator, which is the only iterator implementing the Iterator
 * interface due to its specific requirement.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
interface StdInterface extends IteratorAggregate
{
	/*
	 * Container to Array.
	 * 
	 * PHP array functions do not accept Iterator or IteratorAggregate 
	 * instances as the array argument. This used to isolate PCON containers 
	 * from the built-in or user defined array functions. This method provides
	 * a consistent way in adapting PCON containers into existing systems. 
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
	 * Since all the memory management is handled by the PHP internals, such a
	 * component can only be written based on arrays.
	 *
	 * @return array
	 */
	public function toArray();
}
