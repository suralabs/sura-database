<?php

/*
 * Copyright (c) 2023 Sura
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

 namespace Tephida\Database\Exception;

use Tephida\Corner\CornerTrait;

/**
 * InvalidIdentifier.
 *
 * @package Tephida\Database
 */
class InvalidIdentifier extends \InvalidArgumentException implements ExceptionInterface
{
    use CornerTrait;
}
