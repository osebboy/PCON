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
 * @package    PCON\Tests\Maps
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Tests\Maps;

use PCON\Maps\SplObjectMap;

/**
 * Map Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class SplObjectMapTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->map = new SplObjectMap();
	}

	protected function tearDown() 
	{
	}
	
	public function testAppendInfoShouldTurnMapIntoMultiMap()
	{
		$obj = new \stdClass();
		$this->map->attach($obj);
		$this->map->appendInfo($obj, 'foo');
		$this->map->appendInfo($obj, 'bar');
		foreach ($this->map as $obj)
		{
			$this->assertEquals(array('foo', 'bar'), $this->map->getInfo());
		}
	}
	
	public function testRemoveInfoShouldRemoveElementFromMultiMap()
	{
		$obj = new \stdClass();
		$this->map->attach($obj);
		$this->map->appendInfo($obj, 'foo');
		$this->map->appendInfo($obj, 'bar');
		$this->map->removeInfo($obj, 'foo');
		foreach ($this->map as $obj)
		{
			$this->assertEquals(array(1 => 'bar'), $this->map->getInfo());
		}	
	}
	
	
	public function testFilterShouldReturnFilteredObjects()
	{
		$obj1 = new \stdClass();
		$obj1->name = 'kitty';
	
		$obj2 = new \stdClass();
		$obj2->name = 'moondog';

		$obj3 = new \stdClass();
	 	$obj3->name = 'doggie';
	 
	 	$this->map->attach($obj1, 'meow');
	 	$this->map->attach($obj2, 'woof');
	 	$this->map->attach($obj3, 'woof');
	 
	 	$p = function($obj, $info)
	 	{
	 		return ($obj instanceof \stdClass) && ($info === 'woof');
	 	};
	 	
	 	$this->assertEquals(array($obj2, $obj3), $this->map->filter($p));
	}
	
	public function testGetObjectShouldReturnTheObjectFromItsAssociatedData()
	{
		$obj = new \stdClass();
		$this->map->attach($obj);
		$this->map->appendInfo($obj, 'foo');
		$this->map->appendInfo($obj, 'bar');
		$this->assertTrue($obj === $this->map->getObject('foo'));
		$this->assertTrue($obj === $this->map->getObject('bar'));
		$this->assertFalse($obj === $this->map->getObject('zip'));
	}
}