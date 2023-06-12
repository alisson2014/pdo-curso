<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    const DATA_BASE_PATH = __DIR__ . "/../../../base.sqlite";
    public static function createConnection(): PDO
    {
        $connection = new PDO("sqlite:" . self::DATA_BASE_PATH);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
