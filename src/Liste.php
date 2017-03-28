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

namespace PCON;

use Closure;
use IteratorAggregate;
use PCON\Traits\Base;

/**
 * Liste(List) is a sequential container providing utilities to iterate both directions
 * and extracting/adding elements from both sides. While the container elements
 * are accessible directly through their indices with set() and get() methods, the only
 * way to obtain the index of an element is through iteration. That's because the indices
 * would not be constant and can change from one operation to another. It's best if this
 * container is utilized for operations that do not need index interaction. Liste only
 * works with integer keys.
 *
 * Liste provides very effective methods for manipulating the element values. Most of the
 * cases, these operations would be sufficient to utilize this class in a number of ways.
 * It can also be used as a stack or queue.
 *
 * "list" is a reserved name so "Liste" is used instead which means "list" in a few
 * other languages.
 */
class Liste implements IteratorAggregate
{
    /**
     * Base trait.
     */
    use Base;

    /**
     * Apply a function to all elements of the list.
     *
     * @param Closure $closure
     * @return Liste
     */
    public function apply(Closure $closure): Liste
    {
        $this->data = array_map($closure, $this->data);

        return $this;
    }

    /**
     * Assign values. Accepts an array or an instance of Traversable.
     *
     * @param mixed $iterable
     * @return Liste
     */
    public function assign(iterable $iterable): Liste
    {
        $this->data = is_array($iterable) ? array_values($iterable) : iterator_to_array($iterable);

        return $this;
    }
    /**
     * Checks if value exists in the list.
     *
     * @param $value
     * @return bool
     */
    public function contains($value): bool
    {
        return in_array($value, $this->data, true);
    }

    /**
     * Removes an element from the list with its index. The only way to know the index
     * of an element is through iteration. Instead, use remove_if() method.
     *
     * @param $index
     * @return void
     */
    public function erase(int $index): void
    {
        if ( !isset($this->data[$index]) )
        {
            throw new \InvalidArgumentException($index . ' does not exist');
        }
        unset($this->data[$index]);
    }

    /**
     * Filter the elements of the list and return the result set in a new list.
     *
     * @param Closure $predicate
     * @return Liste
     */
    public function filter(Closure $predicate): Liste
    {
        return (new Liste)->assign(array_filter($this->data, $predicate));
    }

    /**
     * Returns the first element of the list.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->data);
    }

    /**
     * Returns the value of $index. If index value does not exist, it will throw an exception.
     *
     * @throws \InvalidArgumentException
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        if ( !isset($this->data[$index]) )
        {
            throw new \InvalidArgumentException($index . ' does not exist');
        }
        return $this->data[$index];
    }

    /**
     * Returns the value of the last element.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->data);
    }

    /**
     * Merge one or more containers to this list.
     *
     * @param \iterable[] ...$containers
     * @return Liste
     */
    public function merge(iterable ...$containers): Liste
    {
        foreach ( $containers as $container )
        {
            $this->data = array_merge($this->data, (is_array($container) ? array_values($container) : iterator_to_array($container)));
        }
        return $this;
    }

    /**
     * Removes an element from the end of the list.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Adds an element to the end of the list and and returns the new
     * number of elements.
     *
     * @param mixed $value
     * @return int
     */
    public function push($value): int
    {
        return array_push($this->data, $value);
    }

    /**
     * Removes value from the list.
     *
     * @param mixed $value
     * @return integer | number of removals
     */
    public function remove($value): int
    {
        return $this->remove_if( function ($v) use($value) { return $v === $value; } );
    }

    /**
     * Remove the elements if satisfies the predicate.
     *
     * @param Closure $predicate | need to return boolean
     * @return integer | number of removed elements
     */
    public function remove_if(Closure $predicate): int
    {
        $found = array_filter($this->data, $predicate);

        foreach ( array_keys($found) as $key )
        {
            unset($this->data[$key]);
        }
        return count($found);
    }

    /**
     * Reverses the order of the elements in the list container, All the index references remain valid.
     *
     * @param boolean $preserve_keys
     * @return Liste | $this
     */
    public function reverse($preserve_keys = true): Liste
    {
        $this->data = array_reverse($this->data, $preserve_keys);

        return $this;
    }

    /**
     * Set value. Index need to be an integer and it needs to exist. This cannot be used to add new
     * values. List only accepts modification from the beginning or the end of the container.
     *
     * @param int $index
     * @param $value
     * @return Liste
     */
    public function set(int $index, $value): Liste
    {
        $this->data[$index] = $value;

        return $this;
    }

    /**
     * Removes an element from the beginning of the list.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->data);
    }

    /**
     * Shuffles the values of the container. This function assigns new keys to the elements. As a result,
     * all previous references would be invalid. Please note that this method would return true even
     * if the list elements do not change their placements.
     *
     * @return bool
     */
    public function shuffle(): bool
    {
        return shuffle($this->data);
    }

    /**
     * if $comp function is provided in the argument, then sorts the list depending on the function, else
     * it sorts the list in ascending order.
     *
     * @param Closure $comp | compare function
     * @return boolean | true if sorted, false othersise
     */
    public function sort(?Closure $comp = null): bool
    {
        if ( $comp === null )
        {
            $comp = function($x, $y)
            {
                if ( $x == $y )
                {
                    return 0;
                }
                return ($x < $y) ? -1 : 1;
            };
        }
        return uasort($this->data, $comp);
    }

    /**
     * Returns the unique elements in a new list.
     *
     * @return Liste
     */
    public function unique(): Liste
    {
        $list = new Liste;

        foreach ( $this->data as $value )
        {
            if ( !$list->contains($value) )
            {
                $list->push($value);
            }
        }
        return $list;
    }

    /**
     * Adds an element to the beginning of the list.
     *
     * @param mixed $value
     * @return integer | number of elements in list
     */
    public function unshift($value): int
    {
        return array_unshift($this->data, $value);
    }
}