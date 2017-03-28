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
use PCON\Queue;
use PCON\Traits\Adaptor;
use PHPUnit\Framework\TestCase;

/**
 * Queue Test.
 */
class QueueTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array
     */
    public function getData()
    {
        return [
            [ new Queue(['a', 'b', 'c']) ],
            [ new Queue((new Liste)->assign(['a', 'b', 'c']))]
        ];
    }

    /**
     * @dataProvider getData
     * @covers Queue::pop
     * @uses   Adaptor::isEmpty()
     */
    public function testPop(Queue $queue)
    {
        $this->assertEquals('a', $queue->pop());
        $this->assertEquals('b', $queue->pop());
        $this->assertEquals('c', $queue->pop());
        $this->assertTrue($queue->isEmpty());
    }

    /**
     * @dataProvider getData
     * @covers Queue::top
     */
    public function testTop(Queue $queue)
    {
        $this->assertEquals('a', $queue->top());
    }
}