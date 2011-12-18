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

require_once __DIR__ . '/../../TestHelper.php';

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

	public function testClear()
	{
		$array = array(new \stdClass(), new \stdClass());
		$this->set->assign($array);
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
