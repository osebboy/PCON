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

use PCON\Maps\Map;

require_once __DIR__ . '/../../TestHelper.php';

/**
 * Map Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class MapTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->map = new Map();
	}

	protected function tearDown() 
	{
		if (!$this->map->isEmpty())
		{
			$this->map->clear();
		}
	}
	
	public function testAssign()
	{
		$this->map->assign(array('foo', 'bar'));
		$this->assertTrue( 2 === $this->map->size() );
	}
	
	public function testClear()
	{
		$this->map->assign(array('foo', 'bar'));
		$this->map->clear();
		$this->assertTrue( 0 === $this->map->size() );
	}
	
	public function testErase()
	{
		$this->map['foo'] = 'test';
		$this->assertTrue( $this->map->has('foo') );
		$this->map->erase('foo');
		$this->assertTrue( ! $this->map->has('foo') );
	}
	
	public function testEraseShouldReturnTheRemovedElement()
	{
		$this->map['foo'] = 'bar';
		$this->assertTrue( $this->map->erase('foo') === 'bar' );
		$this->map['baz'] = array('foo', 'bar');
		$this->assertTrue( $this->map->erase('baz') === array('foo', 'bar') );
	}
	
	public function testFilterShouldReturnFilteredElements()
	{
		$this->map->assign(array('ant', 'cat', 'cow', 'dog'));
		$p = function ($value)
		{
			return stripos($value, 'o') !== false;
		};
		$this->assertEquals(array(2 => 'cow', 3 => 'dog'), $this->map->filter($p));
	}
	
	public function testFilterShouldPreserveElementKeys()
	{
		$array = array('foo' => 'bar', 'cat' => 'dog', 'animal' => 'fox');
		$this->map->assign($array);
		$p = function ($value)
		{
			return stripos($value, 'o') !== false;
		};
		$this->assertEquals(array('animal' => 'fox', 'cat' => 'dog' ), $this->map->filter($p));	
	}
	
	public function testGetShouldReturnValueAssociatedWithKey()
	{
		$array = array('foo' => 'bar', 10 => 'fox');
		$this->map->assign($array);
		$this->assertTrue($this->map->get('foo') === 'bar');
		$this->assertTrue($this->map->get(10) === 'fox');
	}
	
	public function testHasShouldCheckExistenceOfKey()
	{
		$array = array('foo' => 'bar');
		$this->map->assign($array);
		$this->assertTrue($this->map->has('foo'));
		$this->assertFalse($this->map->has('bar'));
	}
	
	public function testInsertShouldAddKeyValue()
	{
		$this->map->insert('foo', 'bar');
		$this->assertTrue($this->map->has('foo'));
		$this->assertTrue($this->map->get('foo') === 'bar');
	}
	
	public function testIsEmptyShouldReturnBoolean()
	{
		$this->assertTrue($this->map->isEmpty());
		$this->map->insert('foo', 'bar');
		$this->assertFalse($this->map->isEmpty());
	}
	
	public function testKeysShouldReturnAllMapKeys()
	{
		$array = array('foo' => 'bar', 10 => 'fox', 1000 => 'zip');
		$this->map->assign($array);
		$this->assertEquals(array_keys($array), $this->map->keys());
	}
	
	public function testKeysShouldReturnKeysOfValue()
	{
		$array = array('foo', 'bar', 'foo', 'foo');
		$this->map->assign($array);
		$this->assertEquals(array_keys($array, 'foo', true), $this->map->keys('foo'));
	}
	
	public function testOffsetSetShouldAddElementToTheEndIfNoOffsetProvided()
	{
		$this->map[] = 'foo';
		$this->map[] = 'bar';
		$this->map[] = 'bat';
		$this->assertEquals('bat', $this->map[2]);
		$this->assertEquals('bar', $this->map[1]);
		$this->assertEquals('foo', $this->map[0]);
	}
	
	public function testPushBackShouldAddElementToTheEndWithIntegerKey()
	{
		$this->map->push_back('foo');
		$this->map->push_back('bar');
		$this->assertEquals('bar', $this->map[1]);
	}
	
	public function testRemoveShouldRemoveValue()
	{
		$array = array('foo', 'bar', 'foo', 'foo', 'foo');
		$this->map->assign($array);
		$count = $this->map->remove('foo');
		$this->assertEquals(array(1 => 'bar'), $this->map->getIterator()->getArrayCopy());
		$this->assertTrue($this->map->size() === 1);
		$this->assertEquals(4, $count); // remove() return the removed count
	}
	
	public function testSizeShouldReturnTheNumberOfElementsInMap()
	{
		$array = array('foo', 'bar', 'foo', 'foo', 'foo');
		$this->map->assign($array);
		$this->assertTrue($this->map->size() === 5);
		$this->map->clear();
		$this->assertEquals(0, $this->map->size());
	}
}