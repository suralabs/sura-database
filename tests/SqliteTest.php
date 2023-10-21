<?php
/*
 * Copyright (c) 2023 Sura
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use Sura\Database\Database;
use Sura\Database\Exception\ConnectionException;
use Sura\Database\Exception\DriverException;

class SqliteTest extends TestCase
{

    public string $dsn = 'sqlite:files/test.db';

    public function testSqlite()
    {
        //Создаём или открываем базу данных test.db
        $db = new SQLite3("./files/test.db");
        //Закрываем базу данных без удаления объекта
        $db->close();

        $this->assertTrue(true);
    }

    /**
     * @throws ConnectionException
     * @throws DriverException
     */
    public function testCreate()
    {
        $database = new Database($this->dsn, '', '');

        $database->query('
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                name TEXT NOT NULL,
                web TEXT NOT NULL,
                age INTEGER NOT NULL,
                born DATE
            )
        ');

        $this->assertTrue(true);
    }

    public function testInsertOne()
    {
        $database = new Database($this->dsn, '', '');
        $database->query('INSERT INTO users ?', [ // здесь может быть опущен знак вопроса
            'name' => 'Geek',
            'web' => 'http://example.com',
            'age' => 20,
            'born' => null,
        ]);
        $this->assertSame('1', $database->getInsertId());
    }

    public function testInsertTwo()
    {
        $database = new Database($this->dsn, '', '');
        $database->query('INSERT INTO users ?', [ // здесь может быть опущен знак вопроса
            'name' => 'Jon',
            'web' => 'http://example.com',
            'age' => 25,
            'born' => null,
        ]);
        $this->assertSame('2', $database->getInsertId());
    }

    public function testUpdate()
    {
        $database = new Database($this->dsn, '', '');

        $database->query('UPDATE users SET', [
            'name' => 'Jim',
            'age+=' => 1,
        ], 'WHERE id = ?', 1);

        $row = $database->fetch('SELECT * FROM users WHERE id = ?', 1);
        $this->assertSame('Jim', $row['name']);
        $this->assertSame(21, $row['age']);
    }

    /**
     * @throws DriverException
     * @throws ConnectionException
     */
    public function testAll()
    {
        $database = new Database($this->dsn, '', '');
        $rows = $database->fetchAll('SELECT * FROM users');
        $this->assertSame('Jon', $rows['1']['name']);
    }


    /**
     * @throws DriverException
     * @throws ConnectionException
     */
    public function testRemove()
    {
        $database = new Database($this->dsn, '', '');

        $database->query("DROP TABLE users");
        $this->assertTrue(true);

    }
}
