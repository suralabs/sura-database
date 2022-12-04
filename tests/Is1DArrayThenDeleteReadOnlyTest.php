<?php
declare(strict_types=1);

namespace Tephida\Database\Tests;

use InvalidArgumentException;

class Is1DArrayThenDeleteReadOnlyTest extends DatabaseTest
{

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @depends      Tephida\Database\Tests\Is1DArrayTest::testIs1DArray
     * @param callable $cb
     */
    public function testDeleteThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->delete('irrelevant_but_valid_tablename', [[1]]);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testDeleteTableNameEmptyThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->delete('', ['foo' => 'bar']);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testDeleteTableNameInvalidThrowsException(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->expectException(InvalidArgumentException::class);
        $db->delete('1foo', ['foo' => 'bar']);
    }

    /**
     * @dataProvider goodFactoryCreateArgument2DatabaseProvider
     * @param callable $cb
     */
    public function testDeleteConditionsReturnsNull(callable $cb)
    {
        $db = $this->databaseExpectedFromCallable($cb);
        $this->assertEquals(
            $db->delete('irrelevant_but_valid_tablename', []),
            null
        );
    }
}
