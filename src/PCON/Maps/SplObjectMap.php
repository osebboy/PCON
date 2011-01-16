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

use Closure, SplObjectStorage;

/**
 * SplObjectMap is an extension of SplObjectStorage, providing few
 * additional methods that are needed most of the time. 
 * 
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.0
 */
class SplObjectMap extends SplObjectStorage
{
	/**
	 * Creates a Multi Object Map from objects to data.
	 * 
	 * Example:
	 * 
	 * $object = new \stdClass();
	 * 
	 * $map = new SplObjectMap();
	 * $map->attach($object); 
	 * 
	 * $map->appendInfo($object, 'element1');
	 * $map->appendInfo($object, 'element2', 'element3'....);
	 * 
	 * var_dump($map);
	 * 
	 * object(PCON\Maps\SplObjectMap)#7 (1) 
	 * {
  	 * ["storage":"SplObjectStorage":private]=>
  	 * array(1) {
     * 	["00000000096b0e61000000002c958330"]=>
     * 	array(2) {
     * 	 ["obj"]=>
     * 	 object(stdClass)#6 (0) {
     * 	 }
     * 	 ["inf"]=>
     * 	 array(3) {
     *     [0]=>
     *     string(8) "element1"
     *     [1]=>
     *     string(8) "element2"
     *     [2]=>
     *     string(8) "element3"
     * 	  }
     *   }
  	 *  }
	 * }
	 * 
	 * @param object $object
	 * @param mixed  $info | ($info1, $info2...) See example above.
	 * @return boolean | true if value is added, false otherwise
	 */
	public function appendInfo($object, $info)
	{
		$info = array_slice(func_get_args(), 1);
		$data = (array) $this->offsetGet($object);
		if (is_array($data))
		{
			$this->attach($object, array_merge($data, $info));
			return true;
		}
		return false;
	}
	
	/**
	 * Remove a value from multi object map, opposite of append().
	 * 
	 * @param object $object
	 * @param mixed $value | a value in the object info array
	 * @return boolean | true if value is removed, false otherwise
	 */
	public function removeInfo($object, $info)
	{
		$data = $this->offsetGet($object);
		if (is_array($data) && in_array($info, $data, true))
		{
			unset($data[array_search($info, $data, true)]);
			$this->attach($object, $data);
			return true;
		}
		return false;
	}
	
	/**
	 * Run a filter($predicate) through all the storage objects and their 
	 * associated data, then return the filtered objects.
	 * 
	 * $obj1 = new \stdClass();
	 * $obj1->name = 'kitty';
	 * 
	 * $obj2 = new \stdClass();
	 * $obj2->name = 'moondog';
	 * 
	 * $obj3 = new \stdClass();
	 * $obj3->name = 'doggie';
	 * 
	 * $map = new SplObjectMap();
	 * $map->attach($obj1, 'meow');
	 * $map->attach($obj2, 'woof');
	 * $map->attach($obj3, 'woof');
	 * 
	 * $p = function($obj, $info)
	 * {
	 * 		return ($obj instanceof \stdClass) && ($info === 'woof');
	 * };
	 * 
	 * $map->filter($p); // returns array($obj2, $obj3)
	 * 
	 * @param  Closure $p | predicate, arguments ($object, $info), see example
	 * @return array | objects that satisfies the $predicate
	 */
	public function filter(Closure $p)
	{
		$filtered = array();
		foreach ($this as $obj)
		{
			if ($p($obj, $this->getInfo()))
			{
				$filtered[] = $obj;
			}
		}
		return $filtered;
	}

	/**
	 * Get object that is associated with $info.
	 * 
	 * @param  mixed $info | associated data
	 * @return object | storage object
	 */
	public function getObject($info)
	{
		foreach ($this as $obj)
		{
			$i = $this->getInfo();
			
			if (is_array($i))
			{
				foreach ($i as $val)
				{
					if ($val === $info)
					{
						return $obj;
					}
				}
			}
			else
			{
				if ($i === $info)
				{
					return $obj;
				}
			}
		}
		return false;
	}

	/**
	 * Return a PCON\Sets\ObjectSet with the storage objects.
	 * 
	 * @return PCON\Sets\ObjectSet
	 */
	public function toSet()
	{
		$set = new \PCON\Sets\ObjectSet();
		foreach ($this as $obj)
		{
			$set->insert($obj);
		}
		return $set;
	}
}
