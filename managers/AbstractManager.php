<?php

namespace App\Managers;

use App\Config\Database;
use PDO;

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
