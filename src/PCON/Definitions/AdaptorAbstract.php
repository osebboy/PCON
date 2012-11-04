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
namespace PCON\Definitions;

/**
 * Adaptor Abstract. Stacks and Queue are implemented as adaptors. They simply
 * accept an array or an instance of StdInterface as an argument. This enables
 * flexibility in between PCON and regular arrays, which enables adaptors to
 * be used interchangebly.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.beta
 */
abstract class AdaptorAbstract
{
	/**
	 * Container.
	 *
	 * @var array 
	 */
	protected $container;
	
	/**
	 * Constructor.
	 *
	 * @param mixed $container
	 */
	public function __construct($container = null) 
	{
		if ( $container )
		{
			if ( is_array($container) )
			{
				$this->container = array_values($container);
			}
			else if ( $container instanceof StdInterface )
			{
				$this->container = array_values($container->toArray());
			}
			else
			{
				throw new \InvalidArgumentException('Expects array or instance of StdInterface');
			}
		}
		else
		{
			$this->container = [];
		}
	}
	
	/**
	 * Tests if the container is empty
	 *
	 * @return boolean 
	 */
	public function isEmpty()
	{
		return !$this->container;;
	}
	
	/**
	 * Adaptors implement this method depending on the context.
	 *
	 * Stack -> LIFO
	 * Queue -> FIFO
	 *
	 * @return mixed 
	 */
	abstract public function pop();
	
	/**
	 * Adds elements to the end of adaptor.
	 *
	 * @return int | new size of the container
	 */
	public function push($value)
	{
		return array_push($this->container, $value);
	}

	/**
	 * Number of elements in the container.
	 *
	 * @return integer
	 */
	public function size()
	{
		return count($this->container);
	}
}
