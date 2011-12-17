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
 * Array Set is an associative container that stores unique arrays.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class ArraySet extends SetAbstract
{
	/**
	 * Array hash.
	 *
	 * @return string
	 */
	protected function hash($value)
	{
		return md5(serialize($value));
	}

	/**
	 * Is the value array?
	 *
	 * @return boolean
	 */
	protected function isValid($value)
	{
		return is_array($value);
	}
}
