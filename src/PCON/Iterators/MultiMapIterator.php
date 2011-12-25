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
namespace PCON\Iterators;

use PCON\Maps\MultiMap;
use Iterator;

/**
 * MultiMap Iterator.
 *
 * MultiMaps allow more than one element have the same key. MultiMapIterator
 * iterates through the values returning the associated key for the element
 * even if the key is the same for the same element.
 * 
 * <code>
 * // Multiple slots can be connected to one signal.
 * $multiMap = new MultiMap();
 * $multiMap['signal1'] = 'slot1';
 * $multiMap['signal1'] = 'slot2';
 * $multiMap['signal1'] = 'slot3';
 *
 * $multiMap['signal2'] = 'slot1';
 * $multiMap['signal2'] = 'slot2';
 * $multiMap['signal2'] = 'slot3';
 *
 * foreach ( $multiMap as $signal => $slot )
 * {
 * 	echo $signal . ' => ' . $slot . "\n";
 * }
 * </code>
 * 
 * // returns 
 * signal1 => slot1
 * signal1 => slot2
 * signal1 => slot3
 * signal2 => slot1
 * signal2 => slot2
 * signal2 => slot2
 *
 * @author  Omercan Sebboy (www.osebboy.com)
 * @version 1.1
 */
class MultiMapIterator implements Iterator
{
	/**
	 * MultiMap container.
	 * 
	 * @var $map array
	 */
	private $map;

	/**
	 * Current main key position.
	 * 
	 * @var $pos mixed | integer or string
	 */
	private $pos   = 0;
	
	/**
	 * Sub key position.
	 * 
	 * @var $sub | integer
	 */
	private $sub   = 0;
	
	/**
	 * Iterator construct.
	 * 
	 * @param \PCON\Maps\MultiMap $multiMap
	 */
	public function __construct(MultiMap $multiMap)
	{
		$this->map = $multiMap->toArray();

		$this->rewind(); // this sets the position
	}

	/**
	 * Current element.
	 * 
	 * @return mixed
	 */
	public function current()
	{
		return $this->map[$this->pos][$this->sub];
	}

	/**
	 * Current iterator key.
	 * 
	 * @return mixed | integer or string
	 */
	public function key()
	{
		return $this->pos;
	}

	/**
	 * Moves the iterator pointer to next element.
	 * 
	 * @return void
	 */
	public function next()
	{ 
		if ( !isset($this->map[$this->pos][++$this->sub]) )
		{
			next($this->map);
			
			$this->pos = key($this->map);
				
			$this->sub = 0;
		}
	}

	/**
	 * Rewinds iterator pointer to the beginning.
	 * 
	 * @return void
	 */
	public function rewind()
	{
		reset($this->map);

		$this->pos = key($this->map);

		$this->sub = 0;
	}

	/**
	 * Movs iterator position to the defined position.
	 * 
	 * @param mixed $pos | integer or string
	 */
	public function seek($pos)
	{
		if ( !isset($this->map[$pos]) )
		{
			throw new Exception('Position does not exist');
		}
		$this->rewind();
		
		while ( $this->valid() )
		{
			if ( $pos === key($this->map) )
			{
				return;
			}
			$this->next();
		}
	}

	/**
	 * Checks if the current element position is valid.
	 * 
	 * @return boolean
	 */
	public function valid()
	{
		return isset($this->map[$this->pos][$this->sub]);
	}
}
