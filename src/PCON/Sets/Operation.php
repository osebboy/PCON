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

use PCON\Interfaces\SetInterface;
use Closure;

/**
 * Performs Set operations on the SetInterface objects. Generally, these operations
 * return a new Set object with their return values. In this class, this idea was
 * not implemented because of performance reasons. Instead, the operations returns
 * plain PHP arrays with the return values in it. If Set object is needed in
 * return, then Set's build method can be utilized to create a new Set from array.
 * 
 * All operations are based on the fact that the values are hashed and entered as
 * their key in the container.
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class Operation
{
	/**
	 * Gets the difference between two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | difference
	 */
	public static function difference(SetInterface $set1, SetInterface $set2)
	{
		$diff1 = array_diff_key($set1->toArray(), $set2->toArray());
		
       	 	$diff2 = array_diff_key($set2->toArray(), $set1->toArray());

        	return $diff1 + $diff2;
	}
	
	/**
	 * Returns the intersation between two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | intersection
	 */
	public static function intersection(SetInterface $set1, SetInterface $set2)
	{
		return array_intersect_key($set1->toArray(), $set2->toArray());
	}
	
	/**
	 * Subtracts the elements in $set2 from $set1.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array | subtracted values
	 */
	public static function subtract(SetInterface $set1, SetInterface $set2)
	{
		return array_diff_key($set1->toArray(), $set2->toArray());
	}

	/**
	 * Gets the union of two sets.
	 * 
	 * @param SetInterface $set1
	 * @param SetInterface $set2
	 * @return array
	 */
	public static function union(SetInterface $set1, SetInterface $set2)
	{
		return $set1->toArray() + $set2->toArray();
	}
}
