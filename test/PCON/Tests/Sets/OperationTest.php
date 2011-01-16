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
 * @package    PCON\Tests\Sets
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Tests\Sets;

use PCON\Sets\Operation;
use PCON\Sets\StringSet;

/**
 * Operation Test
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class OperationTest extends \PHPUnit_Framework_TestCase 
{
	protected function setUp() 
	{
		$this->set1 = new StringSet();
		$this->set1->build(array('ant', 'cat', 'cow', 'dog', 'fox'));
		
		$this->set2 = new StringSet();
		$this->set2->build(array('ant', 'cat', 'one', 'two'));
	}

	protected function tearDown() 
	{
	}
	
	public function testDifference()
	{
		// two set difference, keys are preserved
		// set 1 first, then set 2
		$diff = array(	md5('cow') => 'cow', 
						md5('dog') => 'dog', 
						md5('fox') => 'fox', 
						md5('one') => 'one', 
						md5('two') => 'two');
		$this->assertEquals($diff, Operation::difference($this->set1, $this->set2));
		$this->assertEquals($diff, Operation::difference($this->set2, $this->set1));
	}
	
	public function testIntersection()
	{
		// two sets are intersected at ant and cat
		$inter = array(md5('ant') => 'ant', md5('cat') => 'cat');
		$this->assertEquals($inter, Operation::intersection($this->set1, $this->set2));
		$this->assertEquals($inter, Operation::intersection($this->set2, $this->set1));
	}
	
	public function testSubtract()
	{
		$set1_set2 = array(	md5('cow') => 'cow', 
						   	md5('dog') => 'dog', 
						   	md5('fox') => 'fox');
		// subtract set1 from set 2 should be the same as $set1_set2
		$this->assertEquals($set1_set2, Operation::subtract($this->set1, $this->set2));
		
		// subtract set 2 from set 1 is 'one' and 'two'		
		$subtracted = Operation::subtract($this->set2, $this->set1);
		
		// should have size 2
		$this->assertEquals(2, count($subtracted));
		
		// values should be one or two
		foreach ($subtracted as $val)
		{
			$this->assertTrue($val === 'one' || $val === 'two');
		}			   
	}
	
	public function testUnion()
	{
		$union = $this->set1->toArray() + $this->set2->toArray();
		$this->assertEquals($union, Operation::union($this->set1, $this->set2));
		$this->assertEquals($union, Operation::union($this->set2, $this->set1));
	}
	
	public function testSort()
	{
		// change set1 sort
		$this->set1->clear();
		$this->assertTrue($this->set1->isEmpty());
		
		// same strings, different sequence
		$this->set1->build(array('cat', 'fox', 'ant', 'dog', 'cow'));
		
		// following function sorts the set from lower to higher (a, b, c...)
		$comp = function ($a, $b)
		{
		    if ($a == $b) {
		        return 0;
		    }
		    return ($a < $b) ? -1 : 1;
		};
		
		// sort the set
		Operation::sort($this->set1, $comp);
		
		// get the values
		$sorted = array_values($this->set1->toArray());
		
		// test sorted set
		$this->assertEquals('ant', $sorted[0]);
		$this->assertEquals('cat', $sorted[1]);
		$this->assertEquals('cow', $sorted[2]);
		$this->assertEquals('dog', $sorted[3]);
		$this->assertEquals('fox', $sorted[4]);
	}
}