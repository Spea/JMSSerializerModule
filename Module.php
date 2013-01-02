<?php

/*
 * This file is part of the JMSSerializerModule package.
 *
 * (c) Martin Parsiegla <martin.parsiegla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file is placed here for compatibility with Zendframework 2's ModuleManager.
 * It allows usage of this module even without composer.
 * The original Module.php is in 'src/JMSSerializerModule' in order to respect PSR-0
 */
require_once __DIR__ . '/src/JMSSerializerModule/Module.php';
