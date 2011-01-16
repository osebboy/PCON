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
	
	public function testErase()
	{
		// current 0 => 'ant', 1 => 'cat' , 2 => 'dog' - size 3
		$this->assertEquals(3, $this->vec->size());
		
		// remove index 1, erase returns the removed value in array (keys not preserved)
		$this->assertEquals(array('cat'), $this->vec->erase(1));
		
		// now indices are 0 => 'ant', 1 => 'dog'
		// the gap between the indices should close, previous index assoc. is lost
		$this->assertEquals('ant', $this->vec[0]);
		$this->assertEquals('dog', $this->vec[1]); // it was cat before
		
		// now index key -> 2 should not exist
		$this->assertFalse($this->vec->offsetExists(2));
		
		// the number of elements in the vector now should be 2
		$this->assertEquals(2, $this->vec->size());
	}
	
	public function testEraseWithLength()
	{	
		// add 2 more elements
		$this->vec->push_back('foo');
		$this->vec->push_back('bar');
		// current 0=>'ant', 1=>'cat' , 2=>'dog', 3=>'foo', 4=>'bar'
		$this->assertEquals(5, $this->vec->size()); // size now should be 5
		
		// erase starting from index 1 until index 3 which is length 3
		// erase returns the removed values in a new array so
		// shold return array('cat', 'dog', 'foo')
		$this->assertEquals(array('cat', 'dog', 'foo'), $this->vec->erase(1, 3));
		
		// now the size(number of elements) of the container should be 2
		$this->assertEquals(2, $this->vec->size());
		
		// the indices should be rearranged
		// 0 => 'ant', 1 => 'bar'
		$this->assertEquals('ant', $this->vec[0]);
		$this->assertEquals('bar', $this->vec[1]);
		
		// there should not be any index after index 1
		$this->assertFalse($this->vec->offsetExists(2));
	}
	
	public function testEraseWithInvalidIndex()
	{
		// current 0 => 'ant', 1 => 'cat' , 2 => 'dog' - size 3
		// erase an index that does not exist should not make any
		// change in the container
		$this->vec->erase(100);
		$this->assertEquals(3, $this->vec->size());
		// container should not add index 100 if not exist
		$this->assertFalse($this->vec->offsetExists(100));
	}
	
	public function testFront()
	{
		$this->assertEquals('ant', $this->vec->front()); // value from beginning
	}
	
	public function testInsert_at()
	{
		// current 0 => 'ant', 1 => 'cat' , 2 => 'dog'
		$this->assertEquals(3, $this->vec->size()); // verify
		
		// insert 'foo' at the index 1
		// insert_at(1, 'foo')
		// now it should be 0 => 'ant', 1 => 'foo' , 2 => 'cat', 'dog'
		$this->vec->insert_at(1, 'foo');
		$this->assertEquals(4, $this->vec->size()); // now size is 4
		$this->assertEquals('ant', $this->vec[0]); // 0 => ant
		$this->assertEquals('foo', $this->vec[1]); // 1 => foo
		$this->assertEquals('cat', $this->vec[2]); // 2 => cat
		$this->assertEquals('dog', $this->vec[3]); // 3 => dog
		$this->assertFalse($this->vec->offsetExists(4)); // no index after 3
	}
	
	public function testInsert_atWithIndexThatDoesNotExist()
	{
		// current 0 => 'ant', 1 => 'cat' , 2 => 'dog'
		$this->assertEquals(3, $this->vec->size()); // verify
		
		// insert with an invalid index which does not exist in the container
		// 100 => foo
		$this->vec->insert_at(100, 'foo');
		// this adds foo at the end of the container with index 3
		$this->assertEquals('foo', $this->vec[3]);
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
	