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
 * Container Adaptor trait for FIFO (Queue) and LIFO (Stack). This is a standalone
 * trait not using the Base trait due to limited operations compared to other
 * standard containers.
 */
trait Adaptor
{
    /**
     * @var array
     */
    private $data;

    /**
     * Adaptor constructor.
     *
     * @param iterable $data
     */
    public function __construct(iterable $data)
    {
        $this->data = is_array($data) ? array_values($data) : iterator_to_array($data);
    }

    /**
     * Checks if this container is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->data;
    }

    /**
     * Pops an element off the beginning or the end of the container depending on FIFO
     * or LIFO.
     *
     * @return mixed
     */
    abstract public function pop();

    /**
     * Peeks at the element that is on top of the container.
     *
     * @return mixed
     */
    abstract public function top();

    /**
     * Adds an element to the container. Returns the new number of elements after
     * adding the new value.
     *
     * @param $value
     * @return int
     */
    public function push($value): int
    {
        return array_push($this->data, $value);
    }

    /**
     * Returns the number of elements in container.
     *
     * @return int
     */
    public function size(): int
    {
        return count($this->data);
    }
}