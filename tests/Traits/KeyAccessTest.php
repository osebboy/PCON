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

use PCON\Traits\KeyAccess;
use PHPUnit\Framework\TestCase;

/**
 * KeyAccess trait test.
 */
class KeyAccessTest extends TestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->mock = $this->getMockForTrait(KeyAccess::class);
        $this->mock->data = ['fname' => 'Albert', 'lname' => 'Einstein'];
    }

    /**
     * @covers KeyAccess::offsetExists
     */
    public function testOffsetExists()
    {
        $this->assertTrue($this->mock->offsetExists('fname'));
    }

    /**
     * @covers KeyAccess::offsetGet
     */
    public function testOffsetGet()
    {
        $this->assertEquals('Einstein', $this->mock->offsetGet('lname'));
    }

    /**
     * @covers KeyAccess::offsetSet
     * @uses   KeyAccess::offsetGet
     */
    public function testOffsetSet()
    {
        $this->mock->offsetSet('work', 'Quantum');
        $this->assertEquals('Quantum', $this->mock->offsetGet('work'));
    }

    /**
     * @covers KeyAccess::offsetUnset
     * @uses   KeyAccess::offsetExists
     */
    public function testOffsetUnset()
    {
        $this->assertTrue($this->mock->offsetExists('fname'));
        $this->mock->offsetUnset('fname');
        $this->assertFalse($this->mock->offsetExists('fname'));
        $this->assertTrue($this->mock->offsetExists('lname'));
    }
}