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
 * Queue is a first in, first out (FIFO) data structure.
 * 
 * PCON\Sequence\Queue offers the basic implementation of Queue data structure
 * which can be used as is or extended.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Queue implements Pcon
{
	/**
	 * Queue.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Returns the last element in the queue container.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->container);
	}
	
	/**
	 * Removes the first element in the container.
	 * 
	 * @return mixed | remoevd element
	 */
	public function dequeue()
	{
		return array_shift($this->container);
	}
	
	/**
	 * Adds a new element to the end of the queue.
	 * 
	 * @param mixed $value@return void
	 */
	public function enqueue($value)
	{
		return array_push($this->container, $value);
	}
	
	/**
	 * Returns the first element in the queue container.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->container);
	}
	
	/**
	 * Iterator, SplFixedArray
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray($this->container);
	}
	
	/**
	 * Checks whether the queue is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}
	
	/**
	 * Returns the number of elements in the queue.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}
}
