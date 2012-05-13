<?php
/*
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
namespace PCON\Traits;

/*
 * Array Key Access trait provides the most common ArrayAccess interface
 * implementation. 
 * 
 * When used with other PCON\Traits, different types of custom containers
 * can be created on the fly without repetition. 
 *
 * <code>
 * use PCON\Definitions\StdInterface;
 * use ArrayAccess;
 *
 * class ObjectContainer implements StdInterface, ArrayAccess
 * {
 *    use Base, KeyAccess;
 *
 *	  // custom implementation
 * }
 * </code>
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
trait KeyAccess
{
	/*
	 * Get element at offset.
	 *
	 * @param mixed $offset
	 * @return mixed 
	 */
	public function at($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
	
	/*
	 * Tests whether the offset exists.
	 *
	 * @param mixed $offset
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return isset($this->container[$offset]);
	}
	
	/*
	 * Alias of at().
	 *
	 * @param mixed
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->at($offset);
	}
	
	/*
	 * Set element at offset.
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void 
	 */
	public function offsetSet($offset, $value)
	{
		$offset ? $this->container[$offset] = $value : $this->container[] = $value;
	}

	/*
	 * Unset element at offset.
	 *
	 * @param mixed $offset
	 * @return void 
	 */	
	public function offsetUnset($offset)
	{
		unset($this->container[$offset]);
	}
}
