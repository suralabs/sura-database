<?php

/*
 * Copyright (c) 2023 Sura
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

declare(strict_types=1);

namespace Sura\Database\Tests;

use InvalidArgumentException;
use Sura\Database\EasyStatement;

class UpdateTest extends DatabaseWriteTest
{

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgChangesReturnsNull(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->assertEquals(
            $db->update('irrelevant_but_valid_tablename', [], ['1=1']),
            null
        );
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgConditionsReturnsNull(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->assertEquals(
            $db->update('irrelevant_but_valid_tablename', ['foo' => 'bar'], []),
            null
        );
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgChangesThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->update('irrelevant_but_valid_tablename', [[1]], ['TRUE' => true]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgConditionsThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->update('irrelevant_but_valid_tablename', ['1=1'], [[1]]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateTableNameThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->update('', ['foo' => 'bar'], ['TRUE' => true]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgChangesKeyThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->update('irrelevant_but_valid_tablename', ['1foo' => 1], ['TRUE' => true]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testUpdateArgConditionsKeyThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->update('irrelevant_but_valid_tablename', ['foo' => 1], ['1foo' => true]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @depends      Sura\Database\Tests\InsertManyTest::testInsertMany
     * @param callable $cb
     */
    public function testUpdateEasyStatement(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $db->insertMany('irrelevant_but_valid_tablename', [['foo' => '1'], ['foo' => '2']]);
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename'),
            2
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [1]),
            1
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [2]),
            1
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [3]),
            0
        );
        $easyStatement = EasyStatement::open()->with('foo = ?', 2);
        $db->update('irrelevant_but_valid_tablename', ['foo' => 3], $easyStatement);
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [2]),
            0
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [3]),
            1
        );
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @depends      Sura\Database\Tests\InsertManyTest::testInsertMany
     * @param callable $cb
     */
    public function testUpdate(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $db->insertMany('irrelevant_but_valid_tablename', [['foo' => '1'], ['foo' => '2']]);
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename'),
            2
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [1]),
            1
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [2]),
            1
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [3]),
            0
        );
        $db->update('irrelevant_but_valid_tablename', ['foo' => 3], ['foo' => 2]);
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [2]),
            0
        );
        $this->assertEquals(
            $db->single('SELECT COUNT(*) FROM irrelevant_but_valid_tablename WHERE foo = ?', [3]),
            1
        );
    }
}
