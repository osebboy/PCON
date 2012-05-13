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
use PCON\Traits\ElementAccess;

/**
 * Queue ( FIFO ).
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 2.0.alpha
 */
class Queue extends AdaptorAbstract
{	
	/**
	 * Trait.
	 */
	use ElementAccess;

	/**
	 * Returns the first element and removes it from queue
	 * effectively reducing the queue size by 1.
	 *
	 * @return mixed
	 */
	public function pop()
	{
		return array_shift($this->container);
	}
}
