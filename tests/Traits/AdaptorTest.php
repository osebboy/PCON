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

namespace PCON\Tests\Traits;

use PCON\Traits\Adaptor;
use PHPUnit\Framework\TestCase;

/**
 * Adaptor trait test.
 */
class AdaptorTest extends TestCase
{
    /**
     * @var object
     */
    private $mock;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mock = $this->getMockForTrait(Adaptor::class, [['a', 'b', 'c']]);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->mock = null;
    }

    /**
     * @covers Adaptor::__construct
     * @covers Adaptor::size
     */
    public function testConstructor()
    {
        $this->assertEquals(3, $this->mock->size());
    }

    /**
     * @covers Adaptor::isEmpty
     */
    public function testIsEmpty()
    {
        $this->assertFalse($this->mock->isEmpty());
    }

    /**
     * @covers Adaptor::push
     * @uses   Adaptor::size
     */
    public function testPush()
    {
        $this->mock->push('d');
        $this->assertEquals(4, $this->mock->size());
    }

    /**
     * @covers Adaptor::pop
     */
    public function testPop()
    {
        $this->mock->method('pop')->will($this->returnValue('c'));
        $this->assertEquals('c', $this->mock->pop());
    }

    /**
     * @covers Adaptor::top
     */
    public function testTop()
    {
        $this->mock->method('top')->will($this->returnValue('c'));
        $this->assertEquals('c', $this->mock->top());
    }
}