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

use PCON\Sequence\Vector;

require_once __DIR__ . '/../../TestHelper.php';

/**
 * Vector Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class VectorTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->vec = new Vector();
		$this->vec->assign(array('ant', 'cat', 'dog'));
	}

	protected function tearDown() 
	{
	}

	public function testAssign()
	{
		// assign removes all previous values
		$array = array('foo', 'bar');
		$this->vec->assign($array);
		$this->assertEquals(2, $this->vec->size());
	}
	
	public function testAssignIntegerArrayKeys()
	{
		// the array argument in assign might have string keys
		// vector just gets values and assigns integer indices
		$array = array('foo' => 'bar', 'cat' => 'dog', 10 => 'zip');
		$this->vec->assign($array);
		// foo, cat and 10 - keys are removed
		// 0, 1, 2 - keys are given
		// strict linear sequence
		foreach ($this->vec as $k => $v)
		{
			$this->assertTrue(in_array($k, array(0, 1, 2), true));
		}
	}
	
	public function testBack()
	{
		$this->assertEquals('dog', $this->vec->back()); // value from end
	}
	
	public function testClear()
	{
		$this->assertEquals(3, $this->vec->size());
		$this->vec->clear();
		$this->assertEquals(0, $this->vec->size());
	}
	
	public function testFront()
	{
		$this->assertEquals('ant', $this->vec->front()); // value from beginning
	}
	
	public function testIsEmpty()
	{
		// current vec is not empty
		$this->assertFalse($this->vec->isEmpty());
		$this->vec->clear();
		$this->assertTrue($this->vec->isEmpty());
	}
	
	public function testPop_back()
	{
		$this->assertEquals('dog', $this->vec->pop_back());
		$this->assertEquals(2, $this->vec->size());
	}
	
	public function testPush_back()
	{
		$this->vec->push_back('foo');
		$this->assertEquals(4, $this->vec->size());
		$this->assertEquals('foo', $this->vec->pop_back());	
	}
	
	public function testReverse()
	{
		// ant is at the beginning(front)
		$this->assertEquals('ant', $this->vec->front());
		
		// reverse
		$this->vec->reverse();
		
		// now fox is front
		$this->assertEquals('dog', $this->vec->front());
		
		// and ant is back(at the end)
		$this->assertEquals('ant', $this->vec->back());
	}
	
	public function testSize()
	{
		$this->assertEquals(3, $this->vec->size());
	}
}
	
