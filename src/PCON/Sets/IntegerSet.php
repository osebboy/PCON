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
namespace PCON\Sets;

/**
 * Integer Set is an associative container that stores unique integer values.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class IntegerSet extends SetAbstract
{
	/**
	 * Integer hash.
	 *
	 * @return string
	 */
	protected function hash($value)
	{
		return md5($value);
	}

	/**
	 * Is the value integer?
	 *
	 * @return boolean
	 */
	protected function isValid($value)
	{
		return is_int($value);
	}
}
