<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    const DATA_BASE_PATH = __DIR__ . "/../../../base.sqlite";
    public static function createConnection(): PDO
    {
        return new PDO("sqlite:" . self::DATA_BASE_PATH);
    }
}
