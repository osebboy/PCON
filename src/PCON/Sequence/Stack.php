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
 * @package    PCON\Sequence
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sequence;

use IteratorAggregate, SplFixedArray;

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
 * @version 1.0
 */
class Stack implements IteratorAggregate
{
	/**
	 * Stack container.
	 * 
	 * @var array
	 */
	protected $stack = array();

	/**
	 * Iterator, SplFixedArray
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray(array_reverse($this->stack));
	}
	
	/**
	 * Returns whether the stack is empty or not
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->stack;
	}
	
	/**
	 * Removes the last element(also known as top) in the stack
	 * 
	 * @return mixed | removed value
	 */
	public function pop()
	{
		return array_pop($this->stack);
	}
	
	/**
	 * Adds an element at the end of the stack.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push($value)
	{
		$this->stack[] = $value;
	}
	
	/**
	 * Returns the number of elements in the stack.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->stack);
	}

	/**
	 * Returns the last element added to the container.
	 * 
	 * @return mixed
	 */
	public function top()
	{
		return end($this->stack);
	}
}
