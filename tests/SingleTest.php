<?php

/*
 * Copyright (c) 2023 Sura
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

declare(strict_types=1);

namespace Tephida\Database\Tests;

use Tephida\Database\Database;

class SingleTest extends CellTest
{
    protected function getResultForMethod(Database $db, $statement, $offset, $params)
    {
        return $db->single($statement, $params);
    }
}
