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
 * @version    2.0.beta
 */
namespace PCON\Traits;

/**
 * Trait for the most common container modifiers.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.beta
 */
trait Modifiers
{
	/**
	 * Fill the container. This method offers 3 different ways to assign values
	 * to the container. Returns itself for chanining.
	 *
	 * // array
	 * $list1 = (new Liste)->assign(array(0 => 'foo', 1 => 'bar'));
	 * 
	 * // arguments
	 * $list2 = (new Liste)->assign('foo', 'bar', 'baz', 'bat');
	 * 
	 * // another PCON container
	 * $list3 = (new Liste)->assign($list1);
	 * 
	 * @param mixed $arg
	 * @return StdInterface instance
	 */
	public function assign($arg)
	{
		$arg = func_get_args();
		
		if ( count($arg) == 1 )
		{
			$arg = is_array($arg[0]) ? $arg[0] : ( $arg[0] instanceof \PCON\Definitions\StdInterface ? $arg[0]->toArray() : $arg );
		}
		$this->container = [];
		
		foreach ( $arg as $k => $v )
		{
			$this->insert($k, $v);
		}
		return $this;
	}
	
	/**
	 * Erase an element with its key.
	 *
     * @param mixed $key
	 * @return void 
	 */
	public function erase($key)
	{
		$ret = null;
		
		if ( isset($this->container[$key]) )
		{
			$ret = $this->container[$key];
			
			unset($this->container[$key]);
		}
		return $ret;
	}
	
	/**
	 * Insert key and value.
	 *
	 * @param mixed $key
	 * @param mixed $value
	 * @return StdInterface instance
	 */
	public function insert($key, $value)
	{
		$this->container[$key] = $value;
		
		return $this;
	}
}
