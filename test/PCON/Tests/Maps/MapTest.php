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
	
	public function testClear()
	{
		$this->map->insert('foo', 'bar');
		$this->map->clear();
		$this->assertTrue( 0 === $this->map->size() );
	}
	
	public function testErase()
	{
		$this->map['foo'] = 'test';
		$this->assertTrue( $this->map->offsetExists('foo') );
		$this->map->erase('foo');
		$this->assertTrue( ! $this->map->offsetExists('foo') );
	}
	
	public function testEraseShouldReturnTheRemovedElement()
	{
		$this->map['foo'] = 'bar';
		$this->assertTrue( $this->map->erase('foo') === 'bar' );
		$this->map['baz'] = array('foo', 'bar');
		$this->assertTrue( $this->map->erase('baz') === array('foo', 'bar') );
	}

	public function testIsEmptyShouldReturnBoolean()
	{
		$this->assertTrue($this->map->isEmpty());
		$this->map->insert('foo', 'bar');
		$this->assertFalse($this->map->isEmpty());
	}
	
	public function testSizeShouldReturnTheNumberOfElementsInMap()
	{
		$this->map->insert('foo', 'bar')->insert('baz', 'bat');
		$this->assertTrue($this->map->size() === 2);
		$this->map->clear();
		$this->assertEquals(0, $this->map->size());
	}
}
