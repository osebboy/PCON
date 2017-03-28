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
use PCON\Stack;
use PCON\Traits\Adaptor;
use PHPUnit\Framework\TestCase;

/**
 * Queue Test.
 */
class StackTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array
     */
    public function getData()
    {
        return [
            [ new Stack(['a', 'b', 'c']) ],
            [ new Stack((new Liste)->assign(['a', 'b', 'c']))]
        ];
    }

    /**
     * @dataProvider getData
     * @covers Stack::pop
     * @uses   Adaptor::isEmpty()
     */
    public function testPop(Stack $stack)
    {
        $this->assertEquals('c', $stack->pop());
        $this->assertEquals('b', $stack->pop());
        $this->assertEquals('a', $stack->pop());
        $this->assertTrue($stack->isEmpty());
    }

    /**
     * @dataProvider getData
     * @covers Stack::top
     */
    public function testTop(Stack $queue)
    {
        $this->assertEquals('c', $queue->top());
    }
}