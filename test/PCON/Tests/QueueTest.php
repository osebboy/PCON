<?php
/*
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
namespace PCON\Tests;

use PCON\Queue;

/**
 * Queue Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class QueueTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->queue = new Queue();
		$this->queue->push('ant');
		$this->queue->push('cat');
		$this->queue->push('fox');
	}

	protected function tearDown() 
	{
	}
	
	public function testBack()
	{
		// returns the element from the end
		$this->assertEquals('fox', $this->queue->back());
	}
	
	public function testPush()
	{
		$queue = new Queue();
		$queue->push('foo');
		$queue->push('bar');
		$this->assertEquals(2, $queue->size());
	}
	
	public function testPop()
	{
		// dequeue() from the beginning at all times
		$this->queue->pop();
		$this->assertEquals(2, $this->queue->size());
		$this->queue->pop();
		$this->queue->pop();
		$this->assertTrue($this->queue->isEmpty());
	}
	
	public function testDequeueReturnsFront()
	{
		// Queue is FIFO
		// dequeue() should remove the front(beginning) continously
		// and should return the removed value
		$this->assertEquals('ant', $this->queue->pop());
		$this->assertEquals('cat', $this->queue->pop());
		$this->assertEquals('fox', $this->queue->pop());
	}

	public function testFront()
	{
		// returns the element from the beginning
		$this->assertEquals('ant', $this->queue->front());
	}
	
	public function testIsEmpty()
	{
		$this->assertFalse($this->queue->isEmpty());
		$this->queue->pop();
		$this->queue->pop();
		$this->queue->pop();
		$this->assertTrue($this->queue->isEmpty());
	}
}
