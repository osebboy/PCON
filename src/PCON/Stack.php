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

use PCON\Definitions\AdaptorAbstract;

/**
 * Stack ( LIFO ).
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Stack extends AdaptorAbstract
{	
	/**
	 * Get the last element and remove it from the stack.
	 *
	 * @return mixed 
	 */
	public function pop()
	{
		return array_pop($this->container);	
	}
	
	/**
	 * Return the last element in the stack.
	 *
	 * @return mixed
	 */
	public function top()
	{
		return end($this->container);
	}
}
