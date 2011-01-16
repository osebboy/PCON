<?php
/**
 * PCON: PHP Containers.
 * 
 * Copyright (c) 2011, Omercan Sebboy <osebboy@gmail.com>.
 * All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE file 
 * that was distributed with this source code.
 *
 * @author     Omercan Sebboy (www.osebboy.com)
 * @package    PCON\Maps
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Maps;

use ArrayAccess;

/**
 * Map Interface presents the base API for a Map container.
 * 
 * @see PCON\Maps\Map
 * @see PCON\Maps\MultiMap
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
interface MapInterface extends ArrayAccess
{
	// accessors
	public function get($key);
	// ArrayAccess
	
	// modifiers
	public function clear();
	public function erase($key);
	public function insert($key, $value);
	
	// validators & capacity
	public function has($key);
	public function isEmpty();
	public function size();
}

