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

use PCON\Liste;

/**
 * Liste Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class ListeTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->list = new Liste();
		$this->list->assign(array('ant', 'cat', 'cow', 'dog', 'fox'));
	}

	public function getFunction()
	{
		$predicate = function($v)
		{
			return in_array($v, array('cat', 'dog'), true);
		};
		return $predicate;
	}
	protected function tearDown() 
	{
	}

	public function testAssignArray()
	{		
		$this->list->assign(array('foo', 'bar'));
		$this->assertEquals(2, $this->list->size()); 
	}
	
	public function testAssignStdInterfaceIntance()
	{
		$set = new Liste();
		$set->assign(array('foo', 'bar'));

		$this->list->assign($set);

		$this->assertEquals(2, $this->list->size());
	}

	public function testAssignArguments()
	{
		$this->list->assign('cat', 'dog', 'fox');
		$this->assertEquals(3, $this->list->size());
	}

	public function testBack()
	{
		$this->assertEquals('fox', $this->list->back());
	}
	
	public function testClear()
	{
		$this->assertEquals(5, $this->list->size());
		$this->list->clear();
		$this->assertTrue($this->list->size() === 0);
	}
	
	public function testErase()
	{
		$this->assertEquals(5, $this->list->size());
		$this->list->erase(0);
		$this->assertEquals(4, $this->list->size());
	}

	public function testEraseShouldReturnRemovedValue()
	{
		$this->assertEquals('ant', $this->list->erase(0));	
	}

	public function testFilterShouldReturnNewList()
	{
		$this->assertTrue($this->list->filter($this->getfunction()) instanceof Liste);
	}

	public function testFilterShouldReturnListWithNewValues()
	{
		$this->assertEquals(2, $this->list->filter($this->getFunction())->size());
	}
	
	public function testFront()
	{
		$this->assertEquals('ant', $this->list->front());
	}

	public function testInsertAcceptsOnlyIntegerValues()
	{
		$this->setExpectedException('PHPUnit_Framework_Error');
		$this->list->insert('foo', 'bar');

		$this->list->insert(10, 'test');
		$this->assertEquals(6, $this->list->size());
	}

	public function testIsEmpty()
	{
		$this->assertFalse($this->list->isEmpty());
		$this->list->clear();
		$this->assertTrue($this->list->isEmpty());
	}

	public function testMergeShouldAddNewValues()
	{
		$list2 = new Liste();
		$list2->assign('foo', 'bar');

		$this->list->merge($list2);
		$this->assertEquals(7, $this->list->size());
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
		$this->assertEquals(4, $this->list->size());
	}

	public function testRemoveShouldReturnNumberOfRemovals()
	{
		$this->list->insert(10, 'ant')->insert(20, 'ant'); 
		$this->assertEquals(3, $this->list->remove('ant'));
	}

	public function testReverse()
	{
		$this->list->reverse();
		$this->assertEquals('fox', $this->list->pop_front());
		$this->assertEquals('ant', $this->list->pop_back());
	}

	public function testSortShouldReturnTrueIfSorted()
	{
		$this->list->assign(array(10 => 'foo', 2 => 'zip',  5 => 'bar'));
		$this->assertEquals(true, $this->list->sort());
	}

	public function testSortWithoutComparisonShouldSortKeysInAscendingOrder()
	{
		$this->list->assign(array(10 => 'foo', 2 => 'zip',  5 => 'bar'));
		$this->list->sort();
		$this->assertEquals('zip', $this->list->front()); // first
		$this->assertEquals('foo', $this->list->back()); // last
	}

	public function testSortShouldSortValuesWithComparisonFunction()
	{
		$this->list->assign(array(10 => 'foo', 2 => 'zip',  5 => 'bar'));
		$comp = function ($a, $b) 
	  	{
    	  		if ($a == $b) 
	  		{
          			return 0;
    	  		}
    	  		return ($a < $b) ? -1 : 1;
	   	};
		$this->list->sort($comp);
		// after sort, the list sequence is bar, foo, zip
		$this->assertEquals('bar', $this->list->front()); // first
		$this->assertEquals('zip', $this->list->back()); // last

		// sorthing values with a comparison function should preserve keys
		$this->assertEquals(array('5' => 'bar', 10 => 'foo', 2 => 'zip'), $this->list->toArray());
	}

	
	public function testSize()
	{
		$this->assertEquals(5, $this->list->size());
	}

	public function testUniqueShouldReturnUniqueValuesInANewList()
	{
		$this->list->assign('foo', 'bar', 'zip', 'zip', 'foo', 'bar');

		$uniqueList = $this->list->unique();
			
		$this->assertTrue($uniqueList instanceof Liste);
		$this->assertEquals(array('foo', 'bar', 'zip'), $uniqueList->toArray());
	}
}
