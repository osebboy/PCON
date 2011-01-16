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

use PCON\Sets\StringSet;

/**
 * String Set Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class StringSetTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->set = new StringSet();
	}

	protected function tearDown() 
	{
	}
	
	public function testBuild()
	{
		$array = array('one', 'two', 'three');
		$this->set->build($array);
		$this->assertEquals(3, $this->set->size());
		
		// build should remove all previous objects in th container
		$this->set->build(array('one'));
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testClear()
	{
		$array = array('one', 'two');
		$this->set->build($array);
		$this->assertEquals(2, $this->set->size());
		$this->set->clear();
		$this->assertEquals(0, $this->set->size());
	}
	
	public function testInsert()
	{
		$this->set->insert('one');
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testInsertShouldThrowNoticeIfNotString()
	{
		$this->setExpectedException('PHPUnit_framework_error');
		$this->set->insert(new \stdClass());
	}
	
	public function testInsertShouldNotAddTheSameStringSecondTime()
	{
		$this->set->insert('one');
		$this->assertEquals(1, $this->set->size());
		$this->set->insert('one');
		$this->set->insert('one');
		$this->set->insert('one');
		$this->set->insert('one');
		$this->set->insert('one');
		$this->assertEquals(1, $this->set->size());
	}
	
	public function testRemove()
	{
		$this->set->build(array('one', 'two'));
		$this->assertEquals(2, $this->set->size());
		$this->set->remove('one');
		$this->assertEquals(1, $this->set->size());
		$this->set->remove('two');
		$this->assertEquals(0, $this->set->size());
	}
	
	public function testFind()
	{
	
		// function to check if the letter 'o' exists in string
		$p = function($string) {
			return stripos($string, 'o') !== false;
		};
		
		// build the set
		$this->set->build(array('one', 'two', 'three', 'four', 'five'));
		$this->assertEquals(5, $this->set->size()); // size now is 5
		
		// run the predicate and return found
		$found = $this->set->find($p);
		
		// only one, two, four have the letter 'o'
		// so the found should have count 3
		$this->assertEquals(3, count($found));
		
		// found should only have one, two, four
		foreach ($found as $val)
		{
			$this->assertTrue(in_array($val, array('one', 'two', 'four'), true));
		}
	}
	
	public function testContains()
	{
		$this->set->insert('one');

	 	// has one
		$this->assertTrue($this->set->contains('one'));
		
		// doesn't have two
		$this->assertFalse($this->set->contains('two'));
	}
	
	public function testIsEmpty()
	{
		// current set is empty
		$this->assertTrue($this->set->isEmpty());
		
		// add string
		$this->set->insert('one');
		// not empty now
		$this->assertFalse($this->set->isEmpty());
	}
	
	public function testSize()
	{
		$this->assertEquals(0, $this->set->size());
		$this->set->insert('one');
		$this->set->insert('two');
		$this->assertEquals(2, $this->set->size());
	}
}