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
 * @package    PCON\Tests\Sequence
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Tests\Sequence;

use PCON\Sequence\Liste;

/**
 * Liste Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class ListeTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->list = new Liste();
		$this->list->assign(array('ant', 'cat', 'cow', 'dog', 'fox'));
	}

	protected function tearDown() 
	{
	}

	public function testAssign()
	{
		$this->list->assign(array('foo', 'bar'));
		$this->assertTrue( ! $this->list->isEmpty());
		
		// make sure all initial values are removed
		// initial count of elements is 5 
		// after foo & bar should be 2 now
		$this->assertEquals(2, $this->list->size()); 
	}
	
	public function testAssignValidator()
	{
		// throw warning if key is string
		$this->setExpectedException('PHPUnit_Framework_Error');
		$this->list->assign(array('foo' => 'bar'));
	}

	public function testBack()
	{
		$this->assertEquals('fox', $this->list->back());
	}
	
	public function testClear()
	{
		$this->list->clear();
		$this->assertTrue($this->list->isEmpty());
	}
	
	public function testErase()
	{
		$this->list->erase(0);
		$this->assertEquals(4, $this->list->size());
		// erase should return removed value
		$this->assertEquals('dog', $this->list->erase(3));
	}
	
	public function testFront()
	{
		$this->assertEquals('ant', $this->list->front());
	}
	
	public function testInsert()
	{
		$this->list->insert(10, 'test');
		$this->assertEquals(6, $this->list->size());
		$this->assertEquals('test', $this->list->erase(10));
	}
	
	public function testIsEmpty()
	{
		$this->assertFalse($this->list->isEmpty());
		$this->list->clear();
		$this->assertTrue($this->list->isEmpty());
	}
	
	public function testPop_back()
	{
		$this->assertEquals('fox', $this->list->pop_back());
		$this->assertEquals(4, $this->list->size());
	}
	
	public function testPop_front()
	{
		$this->assertEquals('ant', $this->list->pop_front());
		$this->assertEquals(4, $this->list->size());
	}
	
	public function testPush_back()
	{
		$this->list->push_back('test');
		$this->assertEquals(6, $this->list->size());
		$this->assertEquals('test', $this->list->pop_back());
	}
	
	public function testPush_front()
	{
		$this->list->push_front('foo');
		$this->assertEquals(6, $this->list->size());
		$this->assertEquals('foo', $this->list->pop_front());
	}
	
	public function testRemove()
	{
		$this->list->remove('ant');
		$this->list->remove('cat');
		foreach ($this->list as $value)
		{
			$this->assertFalse($value === 'ant');
			$this->assertFalse($value === 'cat');
		}
		$this->assertEquals(3, $this->list->size());
	}
	
	public function testRemoveMultipleSameValues()
	{
		$this->list->push_back('foo');
		$this->list->push_back('foo');
		$this->list->push_front('foo');
		// remove returns the number of removals of the value
		$this->assertEquals(3, $this->list->remove('foo'));
	}
	
	public function testReverse()
	{
		$this->list->reverse();
		$this->assertEquals('fox', $this->list->pop_front());
		$this->assertEquals('ant', $this->list->pop_back());
	}
	
	public function testSize()
	{
		$this->assertEquals(5, $this->list->size());
	}
}