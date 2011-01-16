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
 * @package    PCON\Tests\Sets
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Tests\Sets;

use PCON\Sets\ObjectSet;

/**
 * Objset Set Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class ObjectSetTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->set = new ObjectSet();
	}

	protected function tearDown() 
	{
	}
	
	public function testBuild()
	{
		$array = array(new \stdClass(), new \stdClass());
		$this->set->build($array);
		$this->assertEquals(2, $this->set->size());
		
		// build should remove all previous objects in th container
		$this->set->build(array(new \stdClass()));
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testClear()
	{
		$array = array(new \stdClass(), new \stdClass());
		$this->set->build($array);
		$this->assertEquals(2, $this->set->size());
		$this->set->clear();
		$this->assertEquals(0, $this->set->size());
	}
	
	public function testInsert()
	{
		$obj1 = new \stdClass();
		$this->set->insert($obj1);
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testInsertShouldThrowNoticeIfNotObject()
	{
		$this->setExpectedException('PHPUnit_framework_error');
		$this->set->insert('string');
	}
	
	public function testInsertShouldNotAddTheSameObjectSecondTime()
	{
		$obj1 = new \stdClass();
		$this->set->insert($obj1);
		$this->assertEquals(1, $this->set->size());
		$this->set->insert($obj1);
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testRemove()
	{
		$obj1 = new \stdClass();
		$obj2 = new \stdClass();
		$this->set->build(array($obj1, $obj2));
		$this->assertEquals(2, $this->set->size());
		$this->set->remove($obj1);
		$this->assertEquals(1, $this->set->size());
		$this->set->remove($obj2);
		$this->assertEquals(0, $this->set->size());
	}
	
	public function testFind()
	{
		$obj1 = new \stdClass();
		$obj1->name = 'cat';
		$obj2 = new \stdClass();
		$obj2->name = 'cow';
		$obj3 = new \stdClass();
		$obj3->name = 'fox';
		$obj4 = new \stdClass();
		$obj4->name = 'ant';
		
		// function to check if object is instance of stdClass and the letter 'o'
		// exists in its name
		$p = function($object) {
			return ($object instanceOf \stdClass && stripos($object->name, 'o') !== false);
		};
		
		// build the set
		$this->set->build(array($obj1, $obj2, $obj3, $obj4));
		$this->assertEquals(4, $this->set->size()); // size now is 4
		
		// run the predicate and return found
		$found = $this->set->find($p);
		
		// only cow and fox has the letter 'o' in their name
		// so the found should have count 2
		$this->assertEquals(2, count($found));
		
		// found should only have obj2 and obj3
		foreach ($found as $val)
		{
			$this->assertTrue($val === $obj2 || $val === $obj3);
		}
	}
	
	public function testContains()
	{
		$obj = new \stdClass();
		$obj1 = new \stdClass();
		
		// add obj only
		$this->set->insert($obj);
		
		// has obj
		$this->assertTrue($this->set->contains($obj));
		
		// doesn't have obj1
		$this->assertFalse($this->set->contains($obj1));
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
}