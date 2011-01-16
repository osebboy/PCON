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

use IteratorAggregate, Closure;

/**
 * List interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @see PCON\Sequence\Liste
 * @version 1.0
 */
interface ListInterface extends IteratorAggregate
{
	// element access
	public function back();
	public function front();
	
	// modifiers
	public function assign(array $array, $validate = true);
	public function clear();
	public function erase($index);
	public function insert($index, $value);
	public function pop_back();
	public function pop_front();
	public function push_back($value);
	public function push_front($value);
	public function remove($value);
	
	// operations
	public function reverse();
	public function sort();
	
	// validators and capacity
	public function isEmpty();
	public function size();
}