<?php
/**
 * PCON: PHP Containers.
 * 
 * Copyright (c) 2011, Omercan Sebboy <osebboy@gmail.com>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE file 
 * that was distributed with this source code.
 *
 * @author     Omercan Sebboy (www.osebboy.com)
 * @package    PCON\Sequence
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sequence;

use ArrayIterator;

/**
 * Vector is a sequence container which keeps a strict linear sequence
 * between elements. As such, removing or inserting elements to a Vector other
 * than its end will lead the container to rearrange the indices. As a result,
 * the prior index -> value relations will be lost.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class Vector implements VectorInterface
{	
	/**
	 * Vector container.
	 * 
	 * @var array
	 */
	protected $vector = array();
	
	/**
	 * Assigns an array to container which removes all previous
	 * index association in the given array.
	 *  
	 * @param array $array
	 * @return void
	 */
	public function assign(array $array)
	{
		$this->vector = array_values($array);
	}

	/**
	 * Returns an element from the end of the vector.
	 * 
	 * @return mixed
	 */
	public function back()
	{
		return end($this->vector);
	}
	
	/**
	 * Clears the vector and removes all elements.
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->vector = array();
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
	 * $vector->assign(array('a', 'b', 'c', 'd'));
	 * 
	 * $it = $vector->getIterator(); // returns ArrayIterator
	 * 
	 * foreach ($it as $k => $v)
	 * {
	 * 		if ($v === 'c') {
	 * 			unset($it[$k]);
	 * 		}
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
	 * @param integer $length
	 * @return array | the extracted elements
	 */
	public function erase($index, $length = 1)
	{
		return array_splice($this->vector, $index, $length);
	}

	/**
	 * Returns the element from the beginning of vector.
	 * 
	 * @return mixed
	 */
	public function front()
	{
		return reset($this->vector);
	}

	/**
	 * Iterator. 
	 * 
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->vector);
	}

	/**
	 * Inserts an element at the specified index which does not 
	 * remove or replace the pre-existing element, instead 
	 * pushes up all the elements opening a segment for the new
	 * one, rearranges indices, see example below.
	 * 
	 * Ex:
	 * vector ----> array(0 => 'foo', 1 => 'bar')
	 * $this->insert_at(1, 'zip');
	 * 
	 * Now it looks like:
	 * vector ----> array(0 => 'foo', 1 => 'zip', 2 => 'bar')
	 * 
	 * @param integer $index | see example
	 * @param mixed $value
	 * @return array
	 */
	public function insert_at($index, $value)
	{
		return array_splice($this->vector, $index, 0, $value);
	}

	/**
	 * Returns whether the vector container is empty, 
	 * i.e. whether its size is 0
	 * 
	 * @return boolean
	 */
	public function isEmpty()
	{
		return !$this->vector;
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
		return isset($this->vector[$offset]);
	}
	
	/**
	 * Gets an element at the $index, NOTICE is returned if index is invalid.
	 * 
	 * ArrayAccess Interface
	 * 
	 * @param integer $offset
	 * @return mixed | element if offset is set, else NOTICE
	 */
	public function offsetGet($offset)
	{
		return isset($this->vector[$offset]) ? $this->vector[$offset] : trigger_error('Invalid index');
	}
	
	/**
	 * If the index exists then its value is replaced, else adds the value
	 * to the end of the vector, which means this does not act like insert_at().
	 * This method is mainly used to replace a value at a certain index point.
	 * 
	 * ArrayAccess Interface
	 * 
	 * @param integer $offset
	 * @param mixed   $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		($offset && isset($this->vector[$offset])) ? $this->vector[$offset] = $value : $this->vector[] = $value;
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
		return array_pop($this->vector);
	}
	
	/**
	 * Adds an element to the end of the vector.
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function push_back($value)
	{
		$this->vector[] = $value;
	}

	/**
	 * Reverses the vector, previous index association will be lost.
	 * 
	 * @return void
	 */
	public function reverse()
	{
		$this->vector = array_reverse($this->vector);
	}

	/**
	 * Returns the number of elements in vector.
	 * 
	 * @return integer
	 */
	public function size()
	{
		return (int) count($this->vector);
	}
}
?>