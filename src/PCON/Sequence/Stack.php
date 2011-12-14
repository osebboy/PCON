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

use PCON\Interfaces\Pcon;
use SplFixedArray;

/**
 * Stack is a last in, first out(LIFO) data structure and is known by
 * two main operations: 
 * - push() adds an element to the top(end) of the stack
 * - pop() removes an element from the top(end) of the stack
 * 
 * This class presents the basic Stack structure which can be used as
 * is or can be extended depending on requirements.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Stack implements Pcon
{
	/**
	 * Stack container.
	 * 
	 * @var array
	 */
	protected $container = array();

	/**
	 * Iterator, SplFixedArray
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_reverse($this->container));
	}
	
	/**
	 * Returns whether the stack is empty or not
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}
	
	/**
	 * Removes the last element(also known as top) in the stack
	 * 
	 * @return mixed | removed value
	 */
	public function pop()
	{
		return array_pop($this->container);
	}
	
	/**
	 * Adds an element at the end of the stack.
	 * 
	 * @param mixed $value
	 * @return integer | new size of stack after $value added
	 */
	public function push($value)
	{
		return array_push($this->container, $value);
	}
	
	/**
	 * Returns the number of elements in the stack.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}

	/**
	 * Returns the last element added to the container.
	 * 
	 * @return mixed
	 */
	public function top()
	{
		return end($this->container);
	}
}
