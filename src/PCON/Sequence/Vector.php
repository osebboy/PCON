<?php
/**
 * PCON: PHP Containers.
 * 
 * Copyright (c) 2011 - 2012, Omercan Sebboy <osebboy@gmail.com>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE file 
 * that was distributed with this source code.
 *
 * @author     Omercan Sebboy (www.osebboy.com)
 * @copyright  Copyright(c) 2011 - 2012, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.1
 */
namespace PCON\Sequence;

use PCON\Interfaces\ContainerInterface;
use PCON\Interfaces\VectorInterface;
use ArrayIterator, Closure;

/**
 * 		< Vector will be depreceated as of v 1.2 >
 * 
 * Vector is a sequence container which keeps a strict linear sequence
 * between elements. As such, removing or inserting elements to a Vector other
 * than its end will lead the container to rearrange the indices. As a result,
 * the prior index -> value relations will be lost.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Vector implements VectorInterface
{	
	/**
	 * Vector container.
	 * 
	 * @var array
	 */
	protected $container = array();
	
	/**
	 * Assign an array of elements with key => $value pairs
	 * or provide arguments.
	 *
	 * @param mixed $args
	 * @return Vector
	 */
	public function assign($args)
	{
		$args = is_array($args) ? $args : ($args instanceof ContainerInterface ? $args->toArray() : func_get_args());

		$this->container = array_values($args);

		return $this;
	}

	/**
	 * Returns an element from the end of the vector.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->container);
	}
	
	/**
	 * Clears the vector and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->container = array();
	}

	/**
	 * Erases an element at the $index and rearranges the indices dynamically, 
	 * DO NOT use this method during iteration since it will lose the index 
	 * association, see example below.
	 * 
	 * If an index needs to be erased during iteration, then iterator should
	 * be called explicitly, only after that, unset operation should be called.
	 * Once iteration is finished, then the array copy should be assigned back
	 * to the vector. Remember that operations on the iterator will not affect
	 * the container because operations would be performed on the container
	 * copy.
	 * 
	 * Ex:
	 * $vector = new Vector();
	 * $vector->assign('a', 'b', 'c', 'd');
	 * 
	 * $it = $vector->getIterator(); // returns ArrayIterator
	 * 
	 * foreach ( $it as $k => $v )
	 * {
	 * 	if ( $v === 'c' ) 
	 *	{
	 * 		unset($it[$k]);
	 * 	}
	 * }
	 * 
	 * current iterator array looks like:
	 * array( 0 => 'a', 1 => 'b', 3 => 'd')
	 * 
	 * There's a gap between indices  1 and 3, which is against the purpose of this 
	 * container. So assign back and remove the gap:
	 *
	 * $vector->assign($it->getArrayCopy());
	 * 
	 * @param integer $index
	 * @return mixed | removed value, null if none removed
	 */
	public function erase($index)
	{
		$ret = null;

		if ( isset($this->container[$index]) )
		{
			$ret = $this->container[$index];

			unset($this->container[$index]);
		}
		$this->container = array_values($this->container);

		return $ret;
	}

	/**
	 * Filter the list with a predicate and return filtered elements
	 * in a new vector. 
	 *
	 * @param $predicate | an instance of Closure returning true, or false
	 * @return Vector
	 */
	public function filter(Closure $predicate)
	{
		$vector = new Vector();
		
		return $vector->assign(array_filter($this->container, $predicate));
	}

	/**
	 * Returns the element from the beginning of vector.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->container);
	}

	/**
	 * Iterator. 
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->container);
	}

	/**
	 * Inserts an element at the specified index. 
	 * 
	 * Index need to be an integer, and it need to either exist in 
	 * the vector or be equal to last index + 1.
	 * 
	 * This method only allows to set a value for the existing index, or
	 * allows to add element to the end of the vector.
	 * 
	 * @param integer $index
	 * @param mixed $value
	 * @return Vector | $this
	 */
	public function insert($index, $value)
	{
		if ( !is_int($index) )
		{
			return trigger_error('Vector expects index to be an integer', E_USER_WARNING);
		}
		if ( !isset($this->container[$index]) || ($index !== $this->size()) )
		{
			return trigger_error('Invalid index', E_USER_WARNING);
		}
		$this->container[$index] = $value;

		return $this;
	}

	/**
	 * Returns whether the vector container is empty, 
	 * i.e. whether its size is 0
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->container;
	}

	/**
	 * Checks if a specified index exists.
	 * 
	 * ArrayAccess Interface
	 * 
	 * @param integer $offset
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return isset($this->container[$offset]);
	}
	
	/**
	 * Gets an element at the $index, NOTICE is returned if index is invalid.
	 * 
	 * ArrayAccess Interface
	 * 
	 * @param integer $offset
	 * @return mixed | element if offset is set, else WARNING
	 */
	public function offsetGet($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : trigger_error('Invalid index', E_USER_WARNING);
	}
	
	/**
	 * Either modify an existing index, or add value to the end of the container.
	 * 
	 * ArrayAccess Interface
	 * 
	 * @param integer $offset
	 * @param mixed   $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$offset ? $this->insert($offset, $value) : $this->container[] = $value;
	}
	
	/**
	 * Alias of erase(), DO NOT use this method during iteration, see erase()
	 * for more information on unsetting offsets during iteration.
	 * 
	 * ArrayInterface
	 * 
	 * @see erase()
	 * @param integer $offset
	 * @return array | the extracted element
	 */
	public function offsetUnset($offset)
	{
		return $this->erase($offset);
	}

	/**
	 * Removes one element from the end of the vector.
	 * 
	 * @return mixed | removed element
	 */
	public function pop_back()
	{
		return array_pop($this->container);
	}
	
	/**
	 * Adds an element to the end of the vector.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		return array_push($this->container, $value);
	}

	/**
	 * Reverses the vector, previous index association will be lost.
	 * 
	 * @return void
	 */
	public function reverse()
	{
		$this->container = array_reverse($this->container);

		return $this;
	}

	/**
	 * Returns the number of elements in vector.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return count($this->vector);
	}

	/**
	 * Return vector in an array.
	 *
	 * @see PCON\Interfaces\ContainerInterface
	 * @return array 
	 */
	public function toArray()
	{
		return $this->container;
	}
}
