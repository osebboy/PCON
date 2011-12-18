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

require_once __DIR__ . '/../../TestHelper.php';

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
		$this->assertFalse($this->multi->offsetExists('animals'));
	}

	
	public function testInsertShouldAddDifferentElementsWithTheSameKey()
	{
		$values = $this->multi->offsetGet('animals');
		$this->multi->clear();
		foreach ($values as $value)
		{
			$this->multi->insert('animals', $value);
		}
		$this->assertEquals(array('cat', 'cow', 'dog', 'fox'), $this->multi->offsetGet('animals'));
	}
	
	public function testIsEmptyShouldReturnBoolean()
	{
		$this->assertFalse($this->multi->isEmpty());
		$this->multi->clear();
		$this->assertTrue($this->multi->isEmpty());
	}
	
	public function testSizeShouldReturnTheNumnerOfKeysInMap()
	{
		$this->assertEquals(1, $this->multi->size());
	}
}
