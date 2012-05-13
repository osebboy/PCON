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

use PCON\Deque;

/**
 * Deque Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class DequeTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->deck = new Deque();
		$this->deck->push_back('ant');
		$this->deck->push_back('cat');
		$this->deck->push_back('cow');
		$this->deck->push_back('dog');
		$this->deck->push_back('fox');
	}

	protected function tearDown() 
	{
	}

	public function testBack()
	{
		$this->assertEquals('fox', $this->deck->back());
	}
	
	public function testFront()
	{
		$this->assertEquals('ant', $this->deck->front());
	}
	
	public function testIsEmpty()
	{
		$this->assertTrue(!$this->deck->isEmpty());
	}
	
	public function testPop_Back()
	{
		$this->assertEquals('fox', $this->deck->pop_back());
		$this->assertTrue($this->deck->size() === 4);
	}
	
	public function testPop_front()
	{
		$this->assertEquals('ant', $this->deck->pop_front());
		$this->assertTrue($this->deck->size() === 4);
	}
	
	public function testPush_Back()
	{
		$this->deck->push_back('foo');
		$this->assertTrue($this->deck->size() === 6);
		$this->assertEquals('foo', $this->deck->pop_back());
	}
	
	public function testPush_Front()
	{
		$this->deck->push_front('foo');
		$this->assertTrue($this->deck->size() === 6);
		$this->assertEquals('foo', $this->deck->pop_front());
	}
	
	public function testReverse()
	{
		$this->assertEquals('ant', $this->deck->front());
		$this->deck->reverse();
		$this->assertEquals('fox', $this->deck->front());
		$this->assertEquals('ant', $this->deck->back());
	}
	
	public function testSize()
	{
		$this->assertTrue($this->deck->size() === 5);
	}
}
