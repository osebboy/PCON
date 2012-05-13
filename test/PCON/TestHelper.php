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
 * @version    1.1
 */

/**
 * To run the tests, simply go to /path/to/PCON, then type phpunit
 * make sure PHPUnit is on your inlcude path
 */
// set_include_path( '/wwwroot/php/lib/php' );

require_once 'PHPUnit/Framework/TestCase.php';

// require_once __DIR__ . '/../../src/PCON/PCON.php';
require_once  __DIR__ . '/../../src/PCON/Definitions/StdInterface.php';
require_once  __DIR__ . '/../../src/PCON/Definitions/AdaptorAbstract.php';
require_once  __DIR__ . '/../../src/PCON/Iterators/MultiMapIterator.php';
require_once  __DIR__ . '/../../src/PCON/Traits/Base.php';
require_once  __DIR__ . '/../../src/PCON/Traits/ElementAccess.php';
require_once  __DIR__ . '/../../src/PCON/Traits/KeyAccess.php';
require_once  __DIR__ . '/../../src/PCON/Traits/Modifiers.php';
require_once  __DIR__ . '/../../src/PCON/Map.php';
require_once  __DIR__ . '/../../src/PCON/MultiMap.php';
require_once  __DIR__ . '/../../src/PCON/Deque.php';
require_once  __DIR__ . '/../../src/PCON/Liste.php';
require_once  __DIR__ . '/../../src/PCON/Queue.php';
require_once  __DIR__ . '/../../src/PCON/Stack.php';
require_once  __DIR__ . '/../../src/PCON/Set.php';
