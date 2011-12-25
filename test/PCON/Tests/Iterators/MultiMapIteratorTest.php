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
namespace PCON\Tests\Iterators;

use PCON\Maps\MultiMap;
use PCON\Iterators\MultiMapIterator;

/**
 * MultiMapIterator Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class MultiMapIteratorTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$multiMap = new MultiMap();

		$multiMap['strings']  = 'one';
		$multiMap['strings']  = 'two';
		$multiMap['strings']  = 'three';

		$multiMap['numbers']  = 10;
		$multiMap['numbers']  = 20;
		$multiMap['numbers']  = 10;

		$this->it = new MultiMapIterator($multiMap);

	}

	protected function tearDown() 
	{

	}

	public function testCurrentShouldReturnTheCurrentAssociatedValue()
	{
		$this->assertEquals('one', $this->it->current());
	}

	public function testKeyShouldReturnTheKeyThatIteratorPointsTo()
	{
		$this->assertEquals('strings', $this->it->key());
	}

	public function testNextShouldMoveTheIteratorPositionToNextElement()
	{
		// iterator points to the first element to start with
		$this->assertEquals('one', $this->it->current());
		$this->it->next();
		$this->assertEquals('two', $this->it->current());
		$this->it->next(); // three
		$this->it->next(); // 10
		$this->assertEquals(10, $this->it->current() );
		$this->it->rewind();
	}

	public function testSeekShouldMoveTheIteratorPointerToTheSpecifiedKey()
	{
		// currently the iterator points to start 'strings' key
		// move to numbers key
		$this->it->seek('numbers');
		$this->assertEquals(10, $this->it->current());
	}
}
