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
 * @version    2.0.alpha
 */
namespace PCON;

use PCON\Definitions\StdInterface;
use PCON\Traits\Base;
use PCON\Traits\KeyAccess;
use PCON\Traits\Modifiers;
use PCON\Traits\ElementAccess;
use ArrayAccess;

/**
 * Double ended queue (deque), also pronounced as deck, is a data structure 
 * which allows elements to be added to or removed from the front (beginning) 
 * or back (end) of it.  
 * 
 * @trait Base
 * @trait KeyAccess 
 * @trait Modifiers 
 * @trait ElementAccess
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Deque implements StdInterface, ArrayAccess
{
	/**
	 * Traits. 
	 */
	use Base, KeyAccess, Modifiers, ElementAccess;

	/**
	 * Insert an element with a key. The least effective insertion. 
     * Deque is most effective adding and removing elements from its
     * beginning and end. Index has to be an integer and need to 
	 * exists. Mainly used to modify an existing value in the deque.
	 *
     * @param integer $key
     * @param mixed $value
	 * @return Deque 
	 */
	public function insert($key, $value)
	{
		if ( !is_int($key) )
		{
			return trigger_error('Deque expects key to be an integer', E_USER_WARNING);
		}
		if ( !isset($this->container[$key]) )
		{
			return trigger_error('Invalid index', E_USER_WARNING);
		}
		$this->container[$key] = $value;

		return $this;
	}
	
	/**
	 * Deque implementation.
	 *
	 * @param integer $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$offset ? $this->insert($offset, $value) : $this->container[] = $value;
	}

	/**
	 * Removes the element from the end of the deque.
	 * 
	 * @return mixed | removed value
	 */
	public function pop_back()
	{
		return array_pop($this->container);
	}

	/**
	 * Removes the element from the beginning of the deque.
	 * 
	 * @return mixed | removed value
	 */
	public function pop_front()
	{
		return array_shift($this->container);
	}
	
	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * @param mixed $value
	 * @return integer | new size of the deque
	 */
	public function push_back($value)
	{
		return array_push($this->container, $value);
	}

	/**
	 * Adds an element to the beginning of the deque.
	 * 
	 * @param mixed $value
	 * @return integer | new size of the deque
	 */
	public function push_front($value)
	{
		return array_unshift($this->container, $value);
	}
	
	/**
	 * Reverses the deque, indices are not preserved.
	 * 
	 * @return Deque
	 */
	public function reverse()
	{
		$this->container = array_reverse($this->container);

		return $this;
	}

	/**
	 * Swap this deque with another.
	 *
	 * @param Deque
	 * @return Deque
	 */
	public function swap(Deque $deque)
	{
		$cp = $this->container;
		
		$this->container = $deque->toArray();
		
		$deque->assign($cp);
		
		unset($cp);
	}
}
