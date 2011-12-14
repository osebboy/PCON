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
 * @copyright  Copyright(c) 2011, Omercan Sebboy (osebboy@gmail.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.0
 */
namespace PCON\Interfaces;

use Closure;

/**
 * List interface.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
interface ListInterface extends ContainerInterface
{
	// element access
	public function back();
	public function front();
	
	// modifiers
	public function assign($args);
	public function clear();
	public function erase($index);
	public function insert($index, $value);
	public function pop_back();
	public function pop_front();
	public function push_back($value);
	public function push_front($value);
	public function remove($value);
	public function remove_if(Closure $predicate);
	
	// operations
	public function filter(Closure $predicate);
	public function reverse($preserve_keys = true);
	public function sort(Closure $comp = null);
	public function unique();
	
	// validators and capacity
	public function isEmpty();
	public function size();
}
