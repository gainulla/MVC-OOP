<?php

namespace App\Repository;

use App\Core\Database;

class PostCUD implements \App\Contracts\CUDInterface
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function save($model): bool
    {
        return true;
    }

    public function remove($model): bool
    {
        return true;
    }
}
