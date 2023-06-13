<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public const DATA_BASE_PATH = __DIR__ . "/../../../base.sqlite";

    /** @return PDO */
    public static function createConnection(): PDO
    {
        $connection = new PDO("sqlite:" . self::DATA_BASE_PATH);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
