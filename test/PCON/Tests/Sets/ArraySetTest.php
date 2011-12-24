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
namespace PCON\Tests\Sets;

use PCON\Sets\ArraySet;

/**
 * ArraySet Test.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class ArraySetTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->set = new ArraySet();
	}

	protected function tearDown() 
	{
	}

	public function testInsert()
	{
		$this->set->insert(array('foo'))->insert(array('bar'));
		$this->assertEquals(2, $this->set->size());
	}
	
	public function testInsertShouldThrowNoticeIfNotString()
	{
		$this->setExpectedException('PHPUnit_framework_error');
		$this->set->insert(new \stdClass());
	}
	
	public function testInsertShouldNotAddTheSameObjectSecondTime()
	{
		$array = array('foo', 'bar');
		$this->set->insert($array);
		$this->assertEquals(1, $this->set->size());

		$this->set->insert($array)->insert($array);
		$this->assertEquals(1, $this->set->size());
	}
}
