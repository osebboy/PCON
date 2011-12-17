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

/**
 * Performs Set operations on the SetInterface instances. Generally, these 
 * operations return a new instance of their respective Set classes. This idea 
 * was not implemented to gain better performance and providing a convenience to 
 * use the return values with built in array functions. The operations returns 
 * plain PHP arrays. If a Set object is needed in return, then the assign() method 
 * can be utilized to create a new Set from the returned array.
 * 
 * <code>
 * $set1 = new StringSet();
 * $set->assign('cat', 'dog');
 * 
 * $set2 = new StringSet();
 * $set2->assign('cow', 'fox');
 * 
 * $newSet = new StringSet();
 * $newSet->assign( Operation::union($set1, $set2) );
 * </code>
 *
 * All Operation methods are based on the hashed values of the elements.
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
	 * Returns the intersection between two sets.
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