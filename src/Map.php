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
use ArrayAccess;
use PCON\Traits\KeyAccess;
use PCON\Traits\Base;

/**
 * Map is an associative container holding elements with a key and a mapped value. Keys are
 * used to identify the elements and sort with unique algorithms.
 *
 * This is an unordered map - there is no compare function run to order the elements by their
 * key during insertion. Sorting is done separately. This class can be extended and the modifiers
 * can be implemented in a way to make it an ordered map.
 */
class Map implements IteratorAggregate, ArrayAccess
{
    /**
     * Traits used.
     */
    use Base, KeyAccess;

    /**
     * Apply a function to each element in Map, which would permanently modifies the Map's elements.
     *
     * @param Closure $closure
     * @return Map
     */
    public function apply(Closure $closure): Map
    {
        $this->data = array_map($closure, $this->data);

        return $this;
    }

    /**
     * Assign values. Accepts an array or an instance of Traversable.
     *
     * @param iterable $iterable
     * @return Map
     */
    public function assign(iterable $iterable): Map
    {
        $this->data = is_array($iterable) ? $iterable : iterator_to_array($iterable, true);

        return $this;
    }

    /**
     * Checks if $value element exists in Map.
     *
     * @param $value
     * @return bool
     */
    public function contains($value): bool
    {
        return in_array($value, $this->data, true);
    }

    /**
     * Deletes an element with its key.
     *
     * @param $key
     * @return bool
     */
    public function erase($key): bool
    {
        if ( !isset($this->data[$key]) )
        {
            return false;
        }
        unset($this->data[$key]);

        return true;
    }

    /**
     * Filters the map with a predicate and returns the filtered values in a new Map.
     *
     * @param Closure $predicate
     * @return Map
     */
    public function filter(Closure $predicate): Map
    {
        return (new Map())->assign(array_filter($this->data, $predicate, ARRAY_FILTER_USE_BOTH ));
    }

    /**
     * Returns the first element in Map.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->data);
    }

    /**
     * Returns the first key of the map.
     *
     * @return mixed
     */
    public function firstKey()
    {
        reset($this->data);

        return key($this->data);
    }

    /**
     * Returns the value associated with a key.
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Checks if $key exists.
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Returns the first key associated with the $value which may occur more than once in the Map.
     *
     * @param $value
     * @return mixed
     */
    public function indexOf($value)
    {
        return array_search($value, $this->data, true);
    }

    /**
     * Returns the keys of Map.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Returns the last element in Map.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->data);
    }

    /**
     * Returns the last key.
     *
     * @return mixed
     */
    public function lastKey()
    {
        end($this->data);

        return key($this->data);
    }

    /**
     * Merges one or more iterable instances.
     *
     * @param \iterable[] ...$containers
     * @return Map
     */
    public function merge(iterable ...$containers): Map
    {
        $this->data = call_user_func_array('array_merge', $this->fromArgs($containers));

        return $this;
    }

    /**
     * Merges one or more arrays recursively.
     *
     * @param \iterable[] ...$containers
     * @return Map
     */
    public function mergeRecursive(iterable ...$containers): Map
    {
        $this->data = call_user_func_array('array_merge_recursive', $this->fromArgs($containers));

        return $this;
    }

    /**
     * Removes one or more elements by its value. Keep in mind that a value may occur more than
     * once in a container. This removes each one and returns the number of removals.
     *
     * @param $value
     * @return int
     */
    public function remove($value): int
    {
        return $this->remove_if( function ($v) use($value) { return $v === $value; } );
    }

    /**
     * Removes elements depending on a predicate. Returns the number of removals.
     *
     * @param Closure $predicate
     * @return int
     */
    public function remove_if(Closure $predicate): int
    {
        $found = array_filter($this->data, $predicate);

        foreach (array_keys($found) as $key)
        {
            unset($this->data[$key]);
        }
        return count($found);
    }

    /**
     * Replaces the values of this Map with values having the same keys in each of the containers presented
     * in arguments. This is not recursive.
     *
     * @param \iterable[] ...$containers
     * @return Map
     */
    public function replace(iterable ...$containers): Map
    {
        $this->data = call_user_func_array('array_replace', $this->fromArgs($containers));

        return $this;
    }

    /**
     * Replaces the values of this Map with values having the same keys in each of the containers presented
     * in arguments recursively.
     *
     * @param \iterable[] ...$containers
     * @return Map
     */
    public function replaceRecursive(iterable ...$containers): Map
    {
        $this->data = call_user_func_array('array_replace_recursive', $this->fromArgs($containers));

        return $this;
    }

    /**
     * Sets a value associated with a key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return Map
     */
    public function set($key, $value): Map
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Sorts the map depending on a predicate. If no predicate given, then this will sort the Map
     * with its keys in ascending order.
     *
     * @param Closure|null $comp
     * @return Map
     */
    public function sort(?Closure $comp = null): Map
    {
        $comp ? uasort($this->data, $comp) : ksort($this->data);

        return $this;
    }

    /**
     * Returns the list representation of this Map. All key associations would be lost because List container
     * only has integer keys.
     *
     * @return Liste
     */
    public function toList(): Liste
    {
        return (new Liste)->assign($this);
    }

    /**
     * Returns the Set representation of this Map. Only unique values would included in Set and the key
     * associations would be lost.
     *
     * @return Set
     */
    public function toSet(): Set
    {
        return (new Set)->assign($this);
    }

    /**
     * Returns the values of this Map.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Internal function for ordering arguments for some methods.
     *
     * @param array $containers
     * @return array
     */
    private function fromArgs(array $containers)
    {
        $list = [$this->data];

        foreach ( $containers as $container )
        {
            $list[] = is_array($container) ? $container : iterator_to_array($container, true);
        }
        return $list;
    }
}