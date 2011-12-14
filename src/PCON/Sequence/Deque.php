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
 * Double ended queue (deque), also pronounced as deck, is a data structure 
 * which only allows elements to be added to or removed from the front (beginning) 
 * or back (end) of it. Deque does not implement PCON\Interfaces\ContainerInterface
 * because of the Deque's structure definition. 
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Deque implements Pcon
{
	/**
	 * Deque container.
	 * 
	 * @var array
	 */
	protected $container = array();

	/**
	 * Returns the element from the end of the deque.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->container);
	}

	/**
	 * Returns the element from the beginning of the deque.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->container);
	}

	/**
	 * Iterator, SplFixedArray.
	 * 
	 * @return SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray($this->container);
	}

	/**
	 * Returns whether the deque container is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}

	/**
	 * Removes the element from the end of the deque.
	 * 
	 * @return mixed | removed value
	 */
	public function pop_back()
	{
		return array_pop($this->container);
	}

	/**
	 * Removes the element from the beginning of the deque.
	 * 
	 * @return moxed | removed value
	 */
	public function pop_front()
	{
		return array_shift($this->container);
	}
	
	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * @param mixed $value
	 * @return int | new size of the deque
	 */
	public function push_back($value)
	{
		return array_push($this->container, $value);
	}

	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * @param mixed $value
	 * @return integer | new size of the deque
	 */
	public function push_front($value)
	{
		return array_unshift($this->container, $value);
	}
	
	/**
	 * Reverses the deque, indices are not preserved.
	 * 
	 * @return void
	 */
	public function reverse()
	{
		$this->container = array_reverse($this->container);

		return $this;
	}
	
	/**
	 * Returns the number of elements in deque.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}
}
