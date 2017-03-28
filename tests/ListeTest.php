<?php
/**
 * PCON: PHP Containers.
 *
 * (c) Omercan Sebboy <osebboy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare(strict_types = 1);

namespace PCON\Tests;

use PCON\Liste;
use PHPUnit\Framework\TestCase;

/**
 * Liste Test
 */
class ListeTest extends TestCase
{
    /**
     * Data provider
     */
    public function getData()
    {
        return [
            [['a', 'b', 'c']],
            [[1, 2, 3]]
        ];
    }

    /**
     * @dataProvider getData
     * @covers Liste::assign
     * @uses   Liste::toArray
     */
    public function testAssign($data)
    {
        $this->assertEquals($data, (new Liste)->assign($data)->toArray());
    }

    /**
     * @covers Liste::apply
     * @uses   Liste::assign
     * @uses   Liste::toArray
     */
    public function testApply()
    {
        $data = ['a', 'b', 'c'];
        $expected = ['A', 'B', 'C'];
        $fn = function($value): string {
            return strtoupper($value);
        };
        $this->assertEquals($expected, (new Liste)->assign($data)->apply($fn)->toArray());
    }

    /**
     * @covers Liste::contains
     * @uses   Liste::toArray
     */
    public function testContains()
    {
        $list = (new Liste)->assign(['a']);
        $this->assertTrue($list->contains('a'));
        $this->assertFalse($list->contains('z'));
    }

    /**
     * @dataProvider getData
     * @covers Liste::erase
     * @uses   Liste::assign
     * @uses   Liste::size
     */
    public function testErase($data)
    {
        $list = (new Liste)->assign($data);
        $list->erase(1);
        $this->assertEquals(2, $list->size());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Liste::erase
     */
    public function testEraseThrowsExceptionIfKeyDoesNotExist()
    {
        (new Liste)->erase(1);
    }

    /**
     * @dataProvider getData
     * @covers Liste::filter
     * @uses   Liste::assign
     * @uses   Liste::size
     */
    public function testFilter($data)
    {
        $list = (new Liste)->assign($data);
        $predicate = function($value) {
            return strpos((string)$value, 'z') !== false;
        };
        $this->assertEquals(0, $list->filter($predicate)->size());
    }

    /**
     * @dataProvider getData
     * @covers Liste::first
     * @uses   Liste::assign
     */
    public function testFirst($data)
    {
        $this->assertRegExp('/a|1/', (string)(new Liste)->assign($data)->first());
    }

    /**
     * @dataProvider getData
     * @covers Liste::get
     * @uses   Liste::assign
     */
    public function testGet($data)
    {
        $this->assertRegExp('/c|3/', (string)(new Liste)->assign($data)->get(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Liste::get
     */
    public function testGetThrowsExceptionIfKeyDoesNotExist()
    {
        (new Liste)->get(1);
    }

    /**
     * @dataProvider getData
     * @covers Liste::last
     * @uses   Liste::assign
     */
    public function testLast($data)
    {
        $this->assertRegExp('/c|3/', (string)(new Liste)->assign($data)->last());
    }

    /**
     * @covers Liste::merge
     * @uses   Liste::assign
     * @uses   Liste::toArray
     */
    public function testMerge()
    {
        $data = $this->getData();
        $xyz  = ['x', 'y', 'z'];
        $merged = array_merge($data[0][0], $data[1][0], $xyz);
        $list = (new Liste())->assign($data[0][0]);
        $list->merge($data[1][0], $xyz);
        $this->assertEquals($merged, $list->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Liste::pop
     * @uses   Liste::assign
     */
    public function testPop($data)
    {
        $this->assertRegExp('/c|3/', (string) (new Liste)->assign($data)->pop());
    }

    /**
     * @dataProvider getData
     * @covers Liste::push
     * @uses   Liste::toArray
     */
    public function testPush($data)
    {
        $list = new Liste();
        foreach ( $data as $value )
        {
            $list->push($value);
        }
        $this->assertEquals($data, $list->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Liste::remove
     * @covers Liste::remove_if
     * @uses   Liste::assign
     */
    public function testRemove($data)
    {
        $list = (new Liste)->assign($data);
        $list->remove('a');
        $list->remove(1);
        $this->assertTrue($list->size() === 2);
        $list->remove('b');
        $list->remove(2);
        $this->assertTrue($list->size() === 1);
    }

    /**
     * @dataProvider getData
     * @covers Liste::reverse
     * @uses   Liste::assign
     * @uses   Liste::toArray
     */
    public function testReverse($data)
    {
        $reversed = [
            [2 => 'c', 1 => 'b', 0 => 'a'],
            [2 => 3, 1 => 2, 0 => 1]
        ];
        $this->assertTrue( in_array((new Liste)->assign($data)->reverse()->toArray(), $reversed, true));
    }

    /**
     * @dataProvider getData
     * @covers Liste::set
     * @uses   Liste::assign
     * @uses   Liste::get
     */
    public function testSet($data)
    {
        $this->assertEquals('cat', (new Liste)->assign($data)->set(1, 'cat')->get(1));
    }

    /**
     * @dataProvider getData
     * @covers Liste::shift
     * @uses   Liste::assign
     */
    public function testShift($data)
    {
        $this->assertRegExp('/a|1/', (string)(new Liste)->assign($data)->shift());
    }

    /**
     * @dataProvider getData
     * @covers Liste::shuffle
     * @uses   Liste::assign
     */
    public function testShuffle($data)
    {
        $this->assertTrue((new Liste)->assign($data)->shuffle());
    }

    /**
     * @dataProvider getData
     * @covers Liste::sort
     * @uses   Liste::assign
     * @uses   Liste::shuffle
     */
    public function testSort($data)
    {
        $list = (new Liste)->assign($data);
        $list->shuffle();
        $list->sort();
        $this->assertRegExp('/c|3/', (string) $list->pop());
        $this->assertRegExp('/a|1/', (string ) $list->shift());
    }

    /**
     * @dataProvider getData
     * @covers Liste::unique
     * @uses   Liste::assign
     * @uses   Liste::toArray
     */
    public function testUnique($data)
    {
        $merged = array_merge($data, ['foo', 'foo', 'foo']);
        $data[] = 'foo';
        $this->assertEquals($data, (new Liste)->assign($merged)->unique()->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Liste::unshift
     * @uses   Liste::assign
     * @uses   Liste::toArray
     */
    public function testUnshift($data)
    {
        $list = (new Liste)->assign($data);
        $list->unshift('foo');
        array_unshift($data, 'foo');
        $this->assertEquals($data, $list->toArray());
    }
}