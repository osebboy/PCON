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

use PCON\Map;
use PHPUnit\Framework\TestCase;

/**
 * Map Test
 */
class MapTest extends TestCase
{
    /**
     * Data provider
     */
    public function getData()
    {
        return [
            [['H' => 'Hydrogen', 'O' => 'Oxygen', 'C' => 'Carbon']],
            [['first' => 'Nikola', 'last' => 'Tesla']]
        ];
    }

    /**
     * @covers Map::apply
     * @uses   Map::assign
     * @uses   Map::toArray
     */
    public function testApply()
    {
        $data = ['a', 'b', 'c'];
        $expected = ['aA', 'bB', 'cC'];
        $fn = function($value): string {
            return $value . strtoupper($value);
        };
        $this->assertEquals($expected, (new Map)->assign($data)->apply($fn)->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Map::assign
     * @uses   Map::toArray
     */
    public function testAssign($data)
    {
        $this->assertEquals($data, (new Map)->assign($data)->toArray());
    }

    /**
     * @covers Map::contains
     * @uses   Map::assign
     */
    public function testContains()
    {
        $this->assertTrue((new Map)->assign($this->getData()[0][0])->contains('Carbon'));
    }

    /**
     * @covers Map::erase
     * @uses   Map::assign
     */
    public function testErase()
    {
        $this->assertTrue((new Map)->assign(['a' => 'b'])->erase('a'));
    }

    /**
     * @covers Map::has
     * @uses   Map::assign
     */
    public function testHas()
    {
        $this->assertTrue((new Map)->assign($this->getData()[0][0])->has('H'));
    }

    /**
     * @dataProvider getData
     * @covers Map::filter
     * @uses   Map::assign
     */
    public function testFilter($data)
    {
        $map = (new Map)->assign($data);
        $predicate = function($value, $index) {
            return in_array($index, ['H', 'first']);
        };
        $filtered = $map->filter($predicate)->toArray();
        $this->assertTrue($filtered == ['H' => 'Hydrogen'] || $filtered == ['first' => 'Nikola']);
    }

    /**
     * @dataProvider getData
     * @covers Map::first
     * @uses   Map::assign
     */
    public function testFirst($data)
    {
        $this->assertTrue(in_array((new Map)->assign($data)->first(),['Hydrogen', 'Nikola']));
    }

    /**
     * @dataProvider getData
     * @covers Map::firstKey
     * @uses   Map::assign
     */
    public function testFirstKey($data)
    {
        $this->assertTrue(in_array((new Map)->assign($data)->firstKey(),['H', 'first']));
    }

    /**
     * @covers Map::get
     * @uses   Map::assign
     */
    public function testGet()
    {
        $this->assertEquals('Tesla', (new Map)->assign($this->getData()[1][0])->get('last'));
    }

    /**
     * @covers Map::indexOf
     * @uses   Map::assign
     */
    public function testIndexOf()
    {
        $this->assertEquals('C', (new Map)->assign($this->getData()[0][0])->indexOf('Carbon'));
    }

    /**
     * @covers Map::keys
     * @uses   Map::assign
     */
    public function testKeys()
    {
        $this->assertEquals(['H', 'O', 'C'], (new Map)->assign($this->getData()[0][0])->keys());
    }

    /**
     * @dataProvider getData
     * @covers Map::last
     * @uses   Map::assign
     */
    public function testLast($data)
    {
        $this->assertTrue(in_array((new Map)->assign($data)->last(), ['Carbon', 'Tesla']));
    }

    /**
     * @dataProvider getData
     * @covers Map::lastKey
     * @uses   Map::assign
     */
    public function testLastKey($data)
    {
        $this->assertTrue(in_array((new Map)->assign($data)->lastKey(), ['C', 'last']));
    }

    /**
     * @covers Map::merge
     * @uses   Map::toArray
     */
    public function testMerge()
    {
        $data = $this->getData();
        $one = $data[0][0];
        $two = $data[1][0];
        $this->assertEquals(array_merge($one, $two), (new Map)->merge($one, $two)->toArray());
    }

    /**
     * @covers Map::mergeRecursive
     * @uses   Map::toArray
     */
    public function testMergeRecursive()
    {
        $one = ['one' => ['two' => 'three']];
        $two = ['one' => ['two' => 'four']];
        $merged = ['one' => ['two' => ['three', 'four']]];
        $this->assertEquals($merged, (new Map)->mergeRecursive($one, $two)->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Map::remove
     * @covers Map::remove_if
     * @uses   Map:;size
     */
    public function testRemove($data)
    {
        $map = (new Map)->assign($data);
        $map->remove('Hydrogen');
        $this->assertEquals(2, $map->size());
    }

    /**
     * @covers Map::replace
     * @uses   Map::assign
     * @uses   Map::toArray
     */
    public function testReplace()
    {
        $a = [0 => 'a', 1 => 'b'];
        $b = [0 => 'y', 1 => 'z'];
        $this->assertEquals([0 => 'y', 1 => 'z'], (new Map)->assign($a)->replace($a, $b)->toArray());
    }

    /**
     * @covers Map::replaceRecursive
     * @uses   Map::assign
     * @uses   Map::toArray
     */
    public function testReplaceRecursive()
    {
        $a = ['a' => ['b' => 'c']];
        $x = ['a' => ['b' => 'x', 'y' => 'z']];
        $this->assertEquals($x, (new Map)->assign($a)->replaceRecursive($x)->toArray());
    }

    /**
     * @covers Map::set
     * @uses   Map::toArray
     */
    public function testSet()
    {
        $this->assertEquals(['a' => 'b'], (new Map)->set('a', 'b')->toArray());
    }

    /**
     * @covers Map::sort
     * @uses   Map::assign
     * @uses   Map::toArray
     */
    public function testSort()
    {
        $this->assertEquals(['a' => 'foo', 'b' => 'bar'], (new Map)->assign(['b' => 'bar', 'a' => 'foo'])->sort()->toArray());
    }

    /**
     * @dataProvider getData
     * @covers Map::toList
     * @uses   Map::assign
     */
    public function testToList($data)
    {
        $this->assertInstanceOf('PCON\Liste', (new Map)->assign($data)->toList());
    }

    /**
     * @dataProvider getData
     * @covers Map::toSet
     * @uses   Map::assign
     */
    public function testToSet($data)
    {
        $this->assertInstanceOf('PCON\Set', (new Map)->assign($data)->toSet());
    }

    /**
     * @dataProvider getData
     * @covers Map::values
     * @uses   Map::assign
     */
    public function testValues()
    {
        $this->assertEquals(['foo', 'bar'], (new Map)->assign(['a' => 'foo', 'b' => 'bar'])->values());
    }
}