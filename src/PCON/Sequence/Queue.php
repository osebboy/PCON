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
 * Queue is a first in, first out (FIFO) data structure.
 * 
 * PCON\Sequence\Queue offers the basic implementation of Queue data structure
 * which can be used as is or extended.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class Queue implements IteratorAggregate
{
	/**
	 * Container.
	 * 
	 * @var array
	 */
	protected $queue = array();
	
	/**
	 * Returns the last element in the queue container.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->queue);
	}
	
	/**
	 * Removes the first element in the container.
	 * 
	 * @return mixed | remoevd element
	 */
	public function dequeue()
	{
		return array_shift($this->queue);
	}
	
	/**
	 * Adds a new element to the end of the queue.
	 * 
	 * @param mixed $value@return void
	 */
	public function enqueue($value)
	{
		$this->queue[] = $value;
	}
	
	/**
	 * Returns the first element in the queue container.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->queue);
	}
	
	/**
	 * Iterator, SplFixedArray
	 * 
	 * @return \SplFixedArray
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray($this->queue);
	}
	
	/**
	 * Checks whether the queue is empty or not.
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->queue;
	}
	
	/**
	 * Returns the number of elements in the queue.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->queue);
	}
}
?>