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
namespace PCON\Interfaces;

use Closure;
use PCON\Interfaces\ContainerInterface;

/**
 * Set Interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
interface SetInterface extends ContainerInterface
{
	// modifiers
	public function assign($args);
	public function erase($value);
	public function insert($value);
	
	// operations
	public function count($value);
	public function sort(Closure $comp);
}
