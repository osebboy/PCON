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

use ArrayAccess;

/**
 * 		< Vector will be depreceated as of v 1.2 >
 *
 * Vector is a type of sequence container which keeps a strict linear sequence
 * between elements. As such, removing or inserting elements to a Vector other
 * than its end will lead the container to rearrange the indices. As a result,
 * the prior index -> value relations will be lost.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
interface VectorInterface extends ContainerInterface, ArrayAccess
{
	// element access
	public function back();
	public function front();
	// + array access
	
	// modifiers
	public function assign($args);
	public function erase($index);
	public function insert($index, $value);
	public function pop_back();
	public function push_back($value);
	
	// operations
	public function reverse();
}
