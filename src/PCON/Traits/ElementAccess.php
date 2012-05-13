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
 * Trait for the first and last element access in a container.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
trait ElementAccess
{
	/*
	 * Get last element.
	 *
	 * @return mixed
	 */
	public function back()
	{
		return end($this->container);
	}

	/*
	 * Get first element.
	 *
	 * @return mixed
	 */	
	public function front()
	{
		return reset($this->container);
	}
}
