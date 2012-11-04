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
 * @version    2.0.beta
 */
namespace PCON\Tests\Iterators;

use PCON\MultiMap;
use PCON\Iterators\MultiMapIterator;

/**
 * MultiMapIterator Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.beta
 */
class MultiMapIteratorTest extends \PHPUnit_Framework_TestCase 
{
	protected $it;

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

	public function traitInit()
	{
		return $this->getObjectForTrait('\PCON\Traits\Base');
	}

	protected function tearDown() 
	{

	}

	public function testKeyShouldReturnTheKeyThatIteratorPointsTo()
	{
		return true; // test for traits
	}
}
