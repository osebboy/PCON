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

use PCON\Sequence\Stack;

/**
 * Stack Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class StackTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		// LIFO
		$this->stack = new Stack();
	}

	protected function tearDown() 
	{
	}

	public function testPush()
	{
		$this->stack->push('foo');
		$this->assertEquals('foo', $this->stack->pop());
		$this->stack->push('bar');
		$this->stack->push('baz');
		$this->assertEquals(2, $this->stack->size());
	}
	
	public function testPop()
	{
		$this->stack->push('ant');
		$this->stack->push('cat');
		$this->stack->push('fox');
		// pop removes the last entered element and returns it
		// so the pop sequence fox, cat, ant
		$this->assertEquals('fox', $this->stack->pop());
		$this->assertEquals('cat', $this->stack->pop());
		$this->assertEquals('ant', $this->stack->pop());
	}
	
	public function testTop()
	{
		$this->stack->push('ant');
		$this->stack->push('cat');
		$this->stack->push('dog');
		$this->stack->push('fox');
		$this->assertEquals('fox', $this->stack->top());
		$this->stack->pop();
		$this->stack->pop();
		$this->assertEquals('cat', $this->stack->top());
	}
	
	public function testIsEmpty()
	{
		// the test stack has no elements
		$this->assertTrue($this->stack->isEmpty());
	}
	
	public function testSize()
	{
		// test stack is empty
		$this->assertEquals(0, $this->stack->size());
		$this->stack->push('cat');
		$this->stack->push('dog');
		$this->assertEquals(2, $this->stack->size());
	}
}
