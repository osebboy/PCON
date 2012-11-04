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
 * @version    2.0.beta
 */
namespace PCON\Tests;

use PCON\MultiMap;

/**
 * MultiMap Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.beta
 */
class MultiMapTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->multi = new MultiMap();
		$this->multi['animals'] = 'cat';
		$this->multi['animals'] = 'cow';
		$this->multi['animals'] = 'dog';
		$this->multi['animals'] = 'fox';
	}

	protected function tearDown() 
	{

	}
	
	public function testClearShouldRemoveAllElements()
	{
		$this->multi->clear();
		$this->assertTrue($this->multi->size() === 0);
	}

	public function testCountShouldReturnNumberOfElementsAssociatedWithKey()
	{
		$this->assertEquals(4, $this->multi->count('animals'));
	}

	public function testCountShouldReturnTheNumberOfElementsUnderKey()
	{
		$this->assertEquals(4, $this->multi->count('animals'));
	}
	
	public function testEraseShouldRemoveKeyAndItsElements()
	{
		$this->multi->erase('animals');
		$this->assertFalse($this->multi->offsetExists('animals'));
	}

	public function testFilterShouldReturnNewMultiMapWithFilteredValues()
	{
		// following returns cat only
		$predicate = function($value)
		{
			return strripos($value, 'a') !== false;
		};
		$filtered = $this->multi->filter($predicate);
		$this->assertTrue($filtered instanceof \PCON\MultiMap);
		$this->assertEquals(1, $filtered->count('animals'));
	}

	public function testGetIteratorReturnsMultiMapIterator()
	{
		$this->assertTrue($this->multi->getIterator() instanceof \PCON\Iterators\MultiMapIterator);
	}

	public function testIteratorShouldPointToTheSameKeyForDifferentValues()
	{
		// returns
		// animals -> cat
		// animals -> cow
		// animals -> dog
		// animals -> fox
		foreach ( $this->multi as $key => $value )
		{
			$this->assertEquals('animals', $key); // key always animal
			$this->assertTrue(in_array($value, array('cat', 'cow', 'dog', 'fox'))); // values for animals
		}
	}

	public function testIndexOf()
	{
		$this->assertEquals('animals', $this->multi->indexOf('cat')); // returns the associated key for the value
	}
	
	public function testInsertShouldAddDifferentElementsWithTheSameKey()
	{
		$values = $this->multi->offsetGet('animals');
		
		$map = new MultiMap();

		foreach ($values as $value)
		{
			$map->insert('animals', $value);
		}
		$this->assertEquals(array('cat', 'cow', 'dog', 'fox'), $map->offsetGet('animals'));
	}
	
	public function testIsEmptyShouldReturnBoolean()
	{
		$this->multi->clear();
		$this->assertTrue($this->multi->isEmpty());
	}
	
	public function testSizeShouldReturnTheNumnerOfKeysInMap()
	{
		// tst fr traits - PCON/Traits/Base
		// $this->assertEquals(1, $this->multi->size());
	}

	public function testRemoveShouldRemoveTheValueAndReturnAssociatedKey()
	{
		$key = $this->multi->remove('cat');
		$this->assertEquals('animals', $key);
		$this->assertFalse($this->multi->indexOf('cat')); // verify removal
	}
}
