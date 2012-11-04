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
 * Default iterator.
 */
use SplFixedArray;

/**
 * Base trait introducing the main methods for PCON containers.
 *
 * This trait enables creating customized containers without repeating the
 * common methods expected to be found in a container.
 *
 * <code>
 * use PCON\Definitions\StdInterface;
 *
 * class MyContainer implements StdInterface
 * {
 *    use Base;
 *    
 *    public function set($key, $val)
 *    {
 *        // code
 *    }
 * 
 *    public function get($key)
 * 	  {
 * 	      // code
 *    }
 * 
 *	  public function has($key)
 *    {
 *	      // code
 *    }
 *
 *	  public function erase($key)
 *    {
 *	      // code
 *    }
 * }
 * </code>
 * If string keys are used in a container, then getIterator() method can be
 * overwritten.
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.beta
 */
trait Base
{
	/**
	 * Container.
	 *
	 * @var array 
	 */
	private $container = [];
	
	/**
	 * Clear the container.
	 *
	 * @return void 
	 */
	public function clear()
	{
		$this->container = [];
	}
	
	/**
	 * By IteratorAggregate interface.
	 *
	 * @return SplFixedArray | default iterator 
	 */
	public function getIterator()
	{
		return SplFixedArray::fromArray($this->container);
	}
	
	/**
	 * Is the container empty?
	 *
	 * @return boolean 
	 */
	public function isEmpty()
	{
		return !$this->container;
	}
	
	/**
	 * Get the number of elements in the container.
	 *
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}
	
	/**
	 * By PCON\Definitions\StdInterface.
	 *
	 * @return array 
	 */
	public function toArray()
	{
		return $this->container;
	}
}
