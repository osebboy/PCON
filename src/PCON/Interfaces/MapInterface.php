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
 * @version    1.0
 */
namespace PCON\Interfaces;

use ArrayAccess, Closure;

/**
 * Map Interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
interface MapInterface extends ContainerInterface, ArrayAccess
{
	// modifiers
	public function erase($key);
	public function insert($key, $value);
	
	// operations
	public function count($key);
	public function indexOf($value);
	public function sort(Closure $comp);
}
