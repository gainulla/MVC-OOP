<?php

namespace App\Repository;

use App\Core\Database;
use App\Models\UserModel;

class UserR implements \App\Contracts\RInterface
{
    private $db;
    private $modelPath;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->modelPath = UserModel::class;
    }

    public function fetch($fields=['*'])
    {
        $users = $this->db
                ->select($fields)
                ->from('users')
                ->orderBy('username')
                ->execute()
                ->fetch($this->modelPath);

        $this->db->reset();

        return (!empty($users) ? $users : NULL);
    }

    public function find($id, $fields=['*'])
    {
        $user = $this->db
                ->select($fields)
                ->from('users')
                ->where(['id' => $id])
                ->execute()
                ->fetch($this->modelPath);

        $this->db->reset();

        return (!empty($user) ? $user[0] : NULL);
    }

    public function findByEmail($email, $fields=['*'])
    {
        $user = $this->db
                ->select($fields)
                ->from('users')
                ->where(['email' => $email])
                ->execute()
                ->fetch($this->modelPath);

        $this->db->reset();

        return (!empty($user) ? $user[0] : NULL);
    }

    public function isUnique($field, $value)
    {
        $user = $this->db
                ->select([$field])
                ->from('users')
                ->where([$field => $value])
                ->execute()
                ->fetch($this->modelPath);

        $this->db->reset();

        return (!empty($user) ? false : true);
    }
}