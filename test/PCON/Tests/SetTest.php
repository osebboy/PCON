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

use PCON\Set;
use stdClass;

/**
 * Set Test.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class SetTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->set = new Set();

		// objects to use
		$this->a   = new stdClass();
		$this->b   = new stdClass();
		$this->c   = new stdClass();
	}

	protected function tearDown() 
	{
	}
	

	public function testAssignArray()
	{		
		$this->set->assign(array($this->a, $this->b, $this->c));
		$this->assertEquals(3, $this->set->size()); 
	}
	
	public function testAssignContainerInterfaceIntance()
	{
		$set = new Set();
		$set->assign(array($this->a, $this->b, $this->c));
		$this->assertEquals(3, $set->size());

		$this->set->assign($set);	
		$this->assertEquals(3, $this->set->size());
	}

	public function testAssignArguments()
	{
		$this->set->assign($this->a, $this->b, $this->c);
		$this->assertEquals(3, $this->set->size());
	}

	public function testClear()
	{
		$this->set->assign($this->a, $this->b, $this->c);
		$this->assertEquals(3, $this->set->size());
		$this->set->clear();
		$this->assertEquals(0, $this->set->size());
	}

	public function testCountShouldReturnTheCountOfElement()
	{
		// sets always return 1 or 0 because sets hold unique elements
		$this->set->assign($this->a, $this->b);
		$this->assertEquals(true, $this->set->contains($this->a));
		$this->assertEquals(false, $this->set->contains($this->c));
	}

	public function testEraseShouldEraseElement()
	{
		$this->set->assign($this->a);
		$this->assertEquals(true, $this->set->contains($this->a));
		$this->set->erase($this->a);
		$this->assertEquals(false, $this->set->contains($this->a));
	}

	public function testFilter()
	{
		$this->set->assign($this->a, $this->b, $this->c);
		$predicate = function($v)
		{
			return in_array($v, array($this->a, $this->b), true);
		};
		$filtered = $this->set->filter($predicate);
		// should return own type of Set
		$this->assertTrue($filtered instanceof \PCON\Set);

		// $filtered should include $this->a, $this->b but not $this->c
		$this->assertEquals(2, $filtered->size());
		$this->assertTrue($filtered->contains($this->a));
		$this->assertFalse($filtered->contains($this->c));
		$this->assertTrue($filtered->contains($this->b));
	}
	
	public function testInsert()
	{
		$this->set->insert($this->a)->insert($this->b);
		$this->assertEquals(2, $this->set->size());
	}

	public function testInsertShouldNotAddTheSameObjectSecondTime()
	{
		$this->set->insert($this->a);
		$this->assertEquals(1, $this->set->size());
		$this->set->insert($this->a)->insert($this->a);
		$this->assertEquals(1, $this->set->size());
	}

	public function testIsEmpty()
	{
		// current set is empty
		$this->assertTrue($this->set->isEmpty());
		
		// add object
		$this->set->insert(new \stdClass());
		// not empty now
		$this->assertFalse($this->set->isEmpty());
	}
	
	public function testSize()
	{
		$this->assertEquals(0, $this->set->size());
		$this->set->insert(new \stdClass());
		$this->assertEquals(1, $this->set->size());
	}

	public function testSort()
	{
		$this->a->name = 'cat';
		$this->b->name = 'fox';
		$this->c->name = 'dog';
		$this->set->assign($this->c, $this->a, $this->b);
		$this->assertEquals(3, $this->set->size()); // we have 3 objects added

		// the following sorts the set according to it's name
		$comp = function ($a, $b) 
	  	{
    	  		if ($a->name == $b->name) 
	  		{
          			return 0;
    	  		}
    	  		return ($a->name < $b->name) ? -1 : 1;
	   	};
		// before sort, set has $this->c, $this->a, $this->b
		$this->set->sort($comp);
		// after sort, the set container is sorted as $this->a, $this->c, $this->b
		$array = $this->set->toArray();

		$this->assertEquals($this->a, array_shift($array));
		$this->assertEquals($this->b, array_pop($array));

	}
}
