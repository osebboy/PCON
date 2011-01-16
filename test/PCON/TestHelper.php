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

/**
 * To run the tests, simply point to Tests dir on the command line: 
 * phpunit test/PCON/Tests
 */
require_once 'PHPUnit\Framework\TestCase.php';

function autoload($class)
{
	require __DIR__ . '/../../src/' . str_replace('\\', '/', ltrim($class)) . '.php';
}

spl_autoload_register ('autoload');