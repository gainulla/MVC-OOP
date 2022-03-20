<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\UserModel;

class UserCUD implements \App\Contracts\CUDInterface
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function save($user): bool
    {
        if ($user->getAttr('id')) {
            $done = $this->db->update('users', [
                'id'            => $user->getAttr('id'),
                'username'      => $user->getAttr('username'),
                'email'         => $user->getAttr('email'),
                'passwordHash'  => $user->getAttr('passwordHash')
            ]);
        } else {
            $done = $this->db->insert('users', [
                'username'      => $user->getAttr('username'),
                'email'         => $user->getAttr('email'),
                'passwordHash'  => $user->getAttr('passwordHash')
            ]);
        }

        $this->db->reset();

        return $done;
    }

    public function remove($user): bool
    {
        // remove user ...
        return false;
    }
}
