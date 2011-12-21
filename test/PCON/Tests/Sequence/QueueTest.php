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
namespace PCON\Tests\Sequence;

use PCON\Sequence\Queue;

/**
 * Queue Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class QueueTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->queue = new Queue();
		$this->queue->enqueue('ant');
		$this->queue->enqueue('cat');
		$this->queue->enqueue('fox');
	}

	protected function tearDown() 
	{
	}
	
	public function testBack()
	{
		// returns the element from the end
		$this->assertEquals('fox', $this->queue->back());
	}
	
	public function testEnqueue()
	{
		$queue = new Queue();
		$queue->enqueue('foo');
		$queue->enqueue('bar');
		$this->assertEquals(2, $queue->size());
	}
	
	public function testDequeue()
	{
		// dequeue() from the beginning at all times
		$this->queue->dequeue();
		$this->assertEquals(2, $this->queue->size());
		$this->queue->dequeue();
		$this->queue->dequeue();
		$this->assertTrue($this->queue->isEmpty());
	}
	
	public function testDequeueReturnsFront()
	{
		// Queue is FIFO
		// dequeue() should remove the front(beginning) continously
		// and should return the removed value
		$this->assertEquals('ant', $this->queue->dequeue());
		$this->assertEquals('cat', $this->queue->dequeue());
		$this->assertEquals('fox', $this->queue->dequeue());
	}

	public function testFront()
	{
		// returns the element from the beginning
		$this->assertEquals('ant', $this->queue->front());
	}
	
	public function testIsEmpty()
	{
		$this->assertFalse($this->queue->isEmpty());
		$this->queue->dequeue();
		$this->queue->dequeue();
		$this->queue->dequeue();
		$this->assertTrue($this->queue->isEmpty());
	}
}
