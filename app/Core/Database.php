<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    private static ?self $instance = null;

    private const DB_HOST = 'mvclyon2025-db-1';
    private const DB_NAME = 'mvc_cours';
    private const DB_USER = 'root';
    private const DB_PASSWORD = 'root';

    public function __construct()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

        try {
            parent::__construct(
                $dsn,
                self::DB_USER,
                self::DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}