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
 * @package    PCON\Sequence
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Sequence;

use ArrayAccess, IteratorAggregate;

/**
 * Vector is a type of sequence container which keeps a strict linear sequence
 * between elements. As such, removing or inserting elements to a Vector other
 * than its end will lead the container to rearrange the indices. As a result,
 * the prior index -> value relations will be lost.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @see PCON\Sequence\Vector
 * @version 1.0
 */
interface VectorInterface extends ArrayAccess, IteratorAggregate
{
	// element access
	public function back();
	public function front();
	// + array access
	
	// modifiers
	public function assign(array $array);
	public function clear();
	public function erase($index, $length = 1);
	public function insert_at($index, $value);
	public function pop_back();
	public function push_back($value);
	
	// operations
	public function reverse();
	
	// capacity
	public function isEmpty();
	public function size();
}