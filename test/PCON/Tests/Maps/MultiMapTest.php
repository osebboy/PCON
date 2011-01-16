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

use PCON\Maps\MultiMap;

/**
 * MultiMap Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
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

	public function testCountShouldReturnTheNumberOfElementsUnderKey()
	{
		$this->assertEquals(4, $this->multi->count('animals'));
	}
	
	public function testEraseShouldRemoveKeyAndItsElements()
	{
		$this->multi->erase('animals');
		$this->assertFalse($this->multi->has('animals'));
	}
	
	public function testFilterShouldReturnFilteredElementsUnderAKey()
	{
		$p = function($value) 
		{
	 		// return all values with letter 'o' in it
	 		return stripos($value, 'o') !== false; 			
	 	};
		$filtered = array(1 => 'cow', 2 => 'dog', 3 => 'fox');
		$this->assertEquals($filtered, $this->multi->filter('animals', $p));
	}
	
	public function testGetShouldReturnArrayOfValuesUnderGivenKey()
	{
		$this->assertEquals(array('cat', 'cow', 'dog', 'fox'), $this->multi->get('animals'));
	}
	
	public function testGetIteratorPositionShouldReturnKeyItaretorPosition()
	{
		$this->assertEquals(null, $this->multi->getIteratorPosition());
		$this->multi->setIteratorPosition('animals');
		$this->assertEquals('animals', $this->multi->getIteratorPosition());
		$this->multi->resetIteratorPosition();
	}
	
	public function testHasShouldCheckExistenceOfKey()
	{
		$this->assertTrue($this->multi->has('animals'));
	}
	
	public function testInsertShouldAddDifferentElementsWithTheSameKey()
	{
		$values = $this->multi->get('animals');
		$this->multi->clear();
		foreach ($values as $value)
		{
			$this->multi->insert('animals', $value);
		}
		$this->assertEquals(array('cat', 'cow', 'dog', 'fox'), $this->multi->get('animals'));
	}
	
	public function testIsEmptyShouldReturnBoolean()
	{
		$this->assertFalse($this->multi->isEmpty());
		$this->multi->clear();
		$this->assertTrue($this->multi->isEmpty());
	}
	
	public function testKeysShouldReturnTheKeysOfMultiMap()
	{
		$this->assertEquals(array('animals'), $this->multi->keys());
	}
	
	public function testRemoveShouldRemoveValueUnderKey()
	{
		$this->multi->remove('animals', 'cat');
		$this->assertTrue($this->multi->count('animals') === 3);
		$this->multi->remove('animals', 'dog');
		$this->assertTrue($this->multi->count('animals') === 2);
	}
	
	public function testResetIteratorPositionShouldResetKeyIteratorToNull()
	{
		$this->multi->setIteratorPosition('animals');
		$this->multi->resetIteratorPosition();
		$this->assertTrue($this->multi->getIteratorPosition() === null);
	}
	
	public function testSetIteratorPositionShouldSetTheIteratorPositionToKey()
	{
		$this->multi->setIteratorPosition('animals');
		$this->assertEquals('animals', $this->multi->getIteratorPosition());
	}
	
	public function testSizeShouldReturnTheNumnerOfKeysInMap()
	{
		$this->assertEquals(1, $this->multi->size());
	}
}