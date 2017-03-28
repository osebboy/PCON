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

use PCON\Liste;
use PCON\Traits\Base;
use PHPUnit\Framework\TestCase;

/**
 * Base trait test.
 */
class BaseTest extends TestCase
{
    /**
     * Base trait mock.
     *
     * @var object
     */
    private $mock;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->mock = $this->getMockForTrait(Base::class);
    }

    /**
     * @covers Base::clear
     * @uses   Base::size
     * @uses   Liste::assign
     */
    public function testClear()
    {
        $list = (new Liste)->assign(['a', 'b']);
        $list->clear();
        $this->assertEquals(0, $list->size());
    }

    /**
     * @covers Base::getIterator
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf('Generator', $this->mock->getIterator());
    }

    /**
     * @covers Base::isEmpty
     */
    public function testIsEmpty()
    {
        $this->assertTrue($this->mock->isEmpty());
    }

    /**
     * @covers Base:size
     */
    public function testSize()
    {
        $this->assertEquals(0, $this->mock->size());
    }

    /**
     * @covers Base::toArray
     */
    public function testToArray()
    {
        $this->assertEquals([], $this->mock->toArray());
    }

    /**
     * @covers Base::toJson
     */
    public function testToJson()
    {
        $this->assertEquals("[]", $this->mock->toJson());
    }
}