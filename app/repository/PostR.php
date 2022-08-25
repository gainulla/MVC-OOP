<?php

namespace App\Repository;

use App\Core\Database;
use App\Models\PostModel;

class PostR implements \App\Contracts\RInterface
{
    private $db;
    private $modelPath;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->modelPath = PostModel::class;
    }

    public function fetch($fields=[]) // mixed
    {
        return true;
    }

    public function find($id, $fields=[]) // mixed
    {
        return true;
    }
}
