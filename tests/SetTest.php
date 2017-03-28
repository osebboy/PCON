<?php
/**
 * PCON: PHP Containers.
 *
 * (c) Omercan Sebboy <osebboy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare(strict_types=1);

namespace PCON\Tests;

use PCON\Set;
use PHPUnit\Framework\TestCase;

/**
 * Set test.
 */
class SetTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array
     */
    public function getData()
    {
        return [
            [[ md5('a') => 'a',  md5('b') => 'b']]
        ];
    }

    /**
     * @dataProvider getData
     * @covers Set::apply
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testApply($data)
    {
        $this->assertEquals(
            ['A', 'B'],
            (new Set)->assign($data)->apply(function($val) { return strtoupper($val); })->values()
        );
    }

    /**
     * @dataProvider getData
     * @covers Set::assign
     * @uses   Set::toArray
     */
    public function testAssign($data)
    {
        $this->assertEquals($data, (new Set)->assign($data)->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Set::contains
     * @uses   Set::assign
     */
    public function testContains($data)
    {
        $this->assertTrue( (new Set)->assign($data)->contains('a') );
    }

    /**
     * @dataProvider getData
     * @covers Set::difference
     * @uses   Set::assign
     * @uses   Set::toArray
     */
    public function testDifference($data)
    {
        $set1 = (new Set)->assign($data);
        $set2 = (new Set)->assign(array_merge($data, ['c']));
        $this->assertEquals([md5('c') => 'c'], Set::difference($set1, $set2)->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Set::filter
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testFilter($data)
    {
        $fn = function($v) {
            return strpos($v, 'a') !== false;
        };
        $this->assertEquals(['a'], (new Set)->assign($data)->filter($fn)->values());
    }

    /**
     * @dataProvider getData
     * @covers Set::first
     * @uses   Set::assign
     */
    public function testFirst($data)
    {
        $this->assertEquals('a', (new Set)->assign($data)->first());
    }

    /**
     * @dataProvider getData
     * @covers Set::getIterator
     * @uses   Set::assign
     */
    public function testGetIterator($data)
    {
        foreach ( (new Set)->assign($data) as $key => $val )
        {
            $this->assertTrue(in_array([$key, $val], [[0,'a'], [1,'b']]));
        }
    }

    /**
     * @dataProvider getData
     * @covers Set::insert
     * @uses   Set::assign
     * @uses   Set::contains
     */
    public function testInsert($data)
    {
        $this->assertTrue((new Set)->assign($data)->contains('b'));
    }

    /**
     * @dataProvider getData
     * @covers Set::insertAll
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testInsertAll($data)
    {
        $set1 = (new Set)->assign($data);
        $set2 = (new Set)->assign(['c']);
        $set3 = (new Set)->assign(['d']);
        $this->assertEquals(['a', 'b', 'c', 'd'], (new Set)->insertAll($set1, $set2, $set3)->values());
    }

    /**
     * @dataProvider getData
     * @covers Set::intersection
     * @uses   Set::assign
     * @uses   Set::toArray
     */
    public function testIntersection($data)
    {
        $set1 = (new Set)->assign($data);
        $set2 = (new Set)->insertAll($set1, (new Set)->assign(['c', 'd']));
        $this->assertEquals($data, Set::intersection($set1, $set2)->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Set::last
     * @uses   Set::assign
     */
    public function testLast($data)
    {
        $this->assertEquals('b', (new Set)->assign($data)->last());
    }

    /**
     * @dataProvider getData
     * @covers Set::pop
     * @uses   Set::assign
     */
    public function testPop($data)
    {
        $this->assertEquals('b', (new Set)->assign($data)->pop());
    }

    /**
     * @dataProvider getData
     * @covers Set::remove
     * @covers Set::remove_if
     * @uses   Set::assign
     */
    public function testRemove($data)
    {
        $this->assertTrue((new Set)->assign($data)->remove('a') == 1);
    }

    /**
     * @dataProvider getData
     * @covers Set::shift
     * @uses   Set::assign
     */
    public function testShift($data)
    {
        $this->assertEquals('a', (new Set)->assign($data)->shift());
    }

    /**
     * @covers Set::sort
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testSort()
    {
        $set = (new Set)->assign(['d', 'b', 'c', 'a']);
        $fn = function($x, $y) {
            if ($x == $y) {
                return 0;
            }
            return ($x < $y) ? -1 : 1;
        };
        $this->assertTrue($set->sort($fn));
        $this->assertEquals(['a', 'b', 'c', 'd'], $set->values());
    }

    /**
     * @dataProvider getData
     * @covers Set::subtract
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testSubtract($data)
    {
        $this->assertEquals(['b'], Set::subtract((new Set)->assign($data), (new Set)->assign(['a']))->values());
    }

    /**
     * @dataProvider getData
     * @covers Set::union
     * @uses   Set::assign
     * @uses   Set::values
     */
    public function testUnion($data)
    {
        $this->assertEquals(['a', 'b', 'c'], Set::union((new Set)->assign($data), (new Set)->assign(['c']))->values());
    }

    /**
     * @dataProvider getData
     * @covers Set::values
     * @uses   Set::assign
     */
    public function testValues($data)
    {
        $this->assertEquals(['a', 'b'], (new Set)->assign($data)->values());
    }
}