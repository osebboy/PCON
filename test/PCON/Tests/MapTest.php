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

use PCON\Map;

require_once __DIR__ . '/../TestHelper.php';

/**
 * Map Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 12.0.alpha
 */
class MapTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->map = new Map();
		$this->map->insert('key', 'value');
	}

	protected function tearDown() 
	{

	}
	
	public function testClear()
	{
		$this->assertTrue( 1 === $this->map->size());
		$this->map->clear();
		$this->assertTrue( 0 === $this->map->size());
	}

	public function testCountShouldReturnTheNumberOfElementsAssociatedWithKey()
	{
		// always return either 1 or 0 for Map.
		// PCON\Maps\MultiMap can return any number because there might be
		// more than 1 value associated with a key
		$this->assertEquals(1, $this->map->count('key'));		
	}
	
	public function testErase()
	{
		$this->assertTrue( $this->map->offsetExists('key') );
		$this->map->erase('key');
		$this->assertTrue( ! $this->map->offsetExists('key') );
	}
	
	public function testEraseShouldReturnTheRemovedElement()
	{
		$this->assertTrue( $this->map->erase('key') === 'value' );
	}

	public function testFilterShouldReturnNewMapContainingFilteredElements()
	{
		$this->map->clear();
		// filter if the element is an instance of stdClass
		$predicate = function($value)
		{
			return $value instanceof \stdClass;
		};
		$a = new \stdClass();
		$b = new \stdClass();

		$this->map->insert('one', $a)
			  ->insert('two', 'value')
			  ->insert('three', $b) 
			  ->insert('four', 'other')
			  ->insert('five', 1234);

		$filtered = $this->map->filter($predicate);

		$this->assertTrue($filtered instanceof \PCON\Map);
		$this->assertEquals(2, $filtered->size());
		
		$includes = array('one' => $a, 'three' => $b);
		$this->assertEquals($includes, $filtered->toArray());
	}

	public function testGetIterator()
	{
		$this->assertTrue($this->map->getIterator() instanceof \ArrayIterator);
	}
	
	public function testIndexOfShouldReturnKeyAssociatedWithValue()
	{
		$this->assertEquals('key', $this->map->indexOf('value'));
		$this->map->clear();
		$this->assertEquals(null, $this->map->indexOf('value'));
	}

	public function testInsert()
	{
		$this->map->clear();
		$this->map->insert('key', 'value');
		$this->assertEquals(1, $this->map->size());
	}

	public function testIsEmptyShouldReturnBoolean()
	{
		$this->map->clear();
		$this->assertTrue($this->map->isEmpty());
		$this->map->insert('foo', 'bar');
		$this->assertFalse($this->map->isEmpty());
	}

	public function testOffsetExists()
	{
		$this->assertTrue($this->map->offsetExists('key'));
	}

	public function testOffsetGet()
	{
		$this->assertEquals('value', $this->map['key']);
	}

	public function testOffsetSet()
	{
		$this->map['a'] = 'b';
		$this->assertTrue(isset($this->map['a']));
	}

	public function testOffsetUnset()
	{
		$this->map->offsetUnset('key');
		$this->assertEquals(0, $this->map->size() );
	}

	public function testRemove()
	{
		$this->assertEquals(true, $this->map->remove('value'));
	}

	public function testSeekShouldSetIteratorPosition()
	{
		$this->map->clear();
		$this->map->insert('a', 1)
			  ->insert('b', 2)
			  ->insert('c', 3) 
			  ->insert('d', 4)
			  ->insert('e', 5);

		// setting the iterator position to the key 'c'
		$this->map->seek('c');

		$it = $this->map->getIterator();

		while ( $it->valid() )
		{
			$this->assertTrue(in_array($it->key(), array('c', 'd', 'e'), true));
			$this->assertTrue(in_array($it->current(), array(3, 4, 5), true));
			
			$it->next();
		}		
	}

	public function testSortValuesWithComparison()
	{
		$comp = function ($a, $b) 
	 	{
    	 		if ($a == $b) 
	 		{
         	 		return 0;
    	 	 	}
    	 		return ($a < $b) ? -1 : 1;
	 	};
		$this->map->clear();

	 	$this->map->insert('foo', 'bar')->insert('zip', 'tar')->insert('cat', 'dog');
		$this->assertEquals(3, $this->map->size());
		$this->assertTrue($this->map->sort($comp)); // map should return true if sorted
	 	$this->assertEquals(array('foo' => 'bar', 'cat' => 'dog', 'zip' => 'tar'), $this->map->toArray()); // true
	}

	public function testSortKeysAscendingOrder()
	{
		$this->map->clear();

	 	$this->map->insert('foo', 'bar')->insert('zip', 'tar')->insert('cat', 'dog');
		$this->assertEquals(3, $this->map->size());
		$this->assertTrue($this->map->sort()); // map should return true if sorted
	 	$this->assertEquals(array('cat' => 'dog', 'foo' => 'bar', 'zip' => 'tar'), $this->map->toArray()); // true
	}

	public function testSizeShouldReturnTheNumberOfElementsInMap()
	{
		$this->map->insert('foo', 'bar')->insert('baz', 'bat');
		$this->assertTrue($this->map->size() === 3);
		$this->map->clear();
		$this->assertEquals(0, $this->map->size());
	}
}
