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

namespace PCON;

use Closure;
use IteratorAggregate;
use PCON\Traits\Base;

/**
 * Set is an associative container that stores unique elements. The elements are
 * the keys themselves.
 */
class Set implements IteratorAggregate
{
    /**
     * Trait.
     */
    use Base;

    /**
     * Apply a function to each element in the container.
     *
     * @param Closure $closure
     * @return Set
     */
    public function apply(Closure $closure): Set
    {
        $data = array_map($closure, $this->data);

        if ( $this->data !== $data )
        {
            // need to recalculate the hash values
            $this->assign($data);
        }
        return $this;
    }

    /**
     * Assign values from either an array or an instance of Traversable.
     *
     * @param mixed $iterable
     * @return Set | $this
     */
    public function assign(iterable $iterable): Set
    {
        $this->data = [];

        foreach ( $iterable as $value )
        {
            $this->insert($value);
        }
        return $this;
    }

    /**
     * Checks if $value exists in Set.
     *
     * @param $value
     * @return bool
     */
    public function contains($value): bool
    {
        return in_array($value, $this->data, true);
    }

    /**
     * Returns the difference between 2 sets.
     *
     * @param Set $set1
     * @param Set $set2
     * @return Set
     */
    public static function difference(Set $set1, Set $set2): Set
    {
        $diff1 = array_diff_key($set1->toArray(), $set2->toArray());

        $diff2 = array_diff_key($set2->toArray(), $set1->toArray());

        return (new Set)->assign(array_merge($diff1, $diff2));
    }

    /**
     * Filter the set with a predicate function.
     *
     * @param Closure $predicate
     * @return Set
     */
    public function filter(Closure $predicate): Set
    {
        return (new Set)->assign(array_filter($this->data, $predicate));
    }

    /**
     * Returns the first element in Set.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->data);
    }

    /**
     * Iterates on the value only.
     *
     * @return iterable
     */
    public function getIterator(): iterable
    {
        foreach ( $this->data as $val )
        {
            yield $val;
        }
    }

    /**
     * Insert a value.
     *
     * @param mixed $value
     * @return Set | $this
     */
    public function insert($value): Set
    {
        if ( is_object($value) )
        {
            $this->data[spl_object_hash($value)] = $value;
        }
        else if ( is_array($value) )
        {
            $this->data[md5(serialize($value))] = $value;
        }
        else
        {
            $this->data[md5($value)] = $value;
        }
        return $this;
    }

    /**
     * Insert all values from other Set(s) to this one.
     *
     * @param Set[] ...$sets
     * @return Set
     */
    public function insertAll(Set ...$sets): Set
    {
        foreach ( $sets as $set )
        {
            $this->data = array_merge($this->data, $set->toArray());
        }
        return $this;
    }

    /**
     * Returns the intersection - the values of $set1 that are present in $set2.
     *
     * @param Set $set1
     * @param Set $set2
     * @return Set
     */
    public static function intersection(Set $set1, Set $set2): Set
    {
        return (new Set)->assign( array_intersect_key($set1->toArray(), $set2->toArray()) );
    }

    /**
     * Returns the last element of Set.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->data);
    }

    /**
     * Removes an element from the end of the Set.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Removes value from Set.
     *
     * @param $value
     * @return bool
     */
    public function remove($value): bool
    {
        if ( ($key = array_search($value, $this->data, true)) !== false )
        {
            unset($this->data[$key]);

            return true;
        }
        return false;
    }

    /**
     * Removes all values that satisfies the predicate and returns the number of
     * removals.
     *
     * @param Closure $predicate
     * @return int
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
     * Removes an element from the beginning of Set and returns it.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->data);
    }

    /**
     * Sort the set values with a Compare function.
     *
     * @param Closure $comp | compare function
     * @return boolean | true if sorted, false otherwise
     */
    public function sort(Closure $comp): bool
    {
        return uasort($this->data, $comp);
    }

    /**
     * Subtracts the elements in $set2 from $set1.
     *
     * @param Set $set1
     * @param Set $set2
     * @return Set
     */
    public static function subtract(Set $set1, Set $set2): Set
    {
        return (new Set)->assign(array_diff_key($set1->toArray(), $set2->toArray()));
    }

    /**
     * Gets the union of two sets.
     *
     * @param Set $set1
     * @param Set $set2
     * @return Set
     */
    public static function union(Set $set1, Set $set2): Set
    {
        return (new Set)->assign(array_merge($set1->toArray() + $set2->toArray()));
    }

    /**
     * Returns the values in an array.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->data);
    }
}