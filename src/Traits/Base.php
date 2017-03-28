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

namespace PCON\Traits;

/**
 * Base Trait for all PCON containers which provides the main methods and the
 * data array. IteratorAggregate interface is implemented in the containers and
 * this trait includes the declaration of getIterator() method.
 */
trait Base
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Removes all the elements from the container.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Per IteratorAggregate interface. The classes utilizing this trait can
     * overwrite this method to have custom iterator implementations.
     *
     * @return iterable
     */
    public function getIterator(): iterable
    {
        foreach ( $this->data as $key => $value )
        {
            yield $key => $value;
        }
    }

    /**
     * Checks the container if empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->data;
    }

    /**
     * Returns the number of elements in the container.
     *
     * @return int
     */
    public function size(): int
    {
        return count($this->data);
    }

    /**
     * Returns the container data in an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Returns the JSON representation of this container.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data);
    }
}