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
 * Double ended queue (deque), also pronounced as deck, is a data structure 
 * which only allows elements to be added to or removed from the front (beginning) 
 * or back (end) of it.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class Deque implements IteratorAggregate
{
	/**
	 * Deque container.
	 * 
	 * @var array
	 */
	protected $deque = array();

	/**
	 * Returns the element from the end of the deque.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->deque);
	}

	/**
	 * Returns the element from the beginning of the deque.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->deque);
	}

	/**
	 * Iterator, SplFixedArray.
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray($this->deque);
	}

	/**
	 * Returns whether the deque container is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->deque;
	}

	/**
	 * Removes the element from the end of the deque.
	 * 
	 * @return mixed | removed value
	 */
	public function pop_back()
	{
		return array_pop($this->deque);
	}

	/**
	 * Removes the element from the beginning of the deque.
	 * 
	 * @return moxed | removed value
	 */
	public function pop_front()
	{
		return array_shift($this->deque);
	}
	
	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		$this->deque[] = $value;
	}

	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * 
	 * @param mixed $value
	 * @return integer | new size of the deque
	 */
	public function push_front($value)
	{
		return array_unshift($this->deque, $value);
	}
	
	/**
	 * Reverses the deque, indices are not preserved.
	 * 
	 * @return void
	 */
	public function reverse()
	{
		$this->deque = array_reverse($this->deque);
	}
	
	/**
	 * Returns the number of elements in deque.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->deque);
	}
}