<?php

namespace App\Repository;

use App\Core\Database;
use App\Core\Token;

class UserCUD implements \App\Contracts\CUDInterface
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function save($user): bool
    {
        if ($user->attr('id') === NULL) {
            $this->db->insert('users');
        } else {
            $this->db->update('users');
        }

        $this->db->set($user->attrAll());

        if ($user->attr('id') !== NULL) {
            $this->db->where(['id' => $user->attr('id')]);
        }

        $affectedRows = $this->db->execute();

        return $affectedRows > 0;
    }

    public function remove($user): bool
    {
        // remove user ...
    }

    public function addPasswordResetHash(Token $token, $user)
    {
        $tokenHash = $token->generate()->getHash();
        $expiryTime = date('Y-m-d H:i:s', time() + 60 * 60);

        $affectedRows = $this->db
            ->update('users')
            ->set([
                'passwordResetHash'      => $tokenHash,
                'passwordResetExpiresAt' => $expiryTime
            ])
            ->where(['id' => $user->attr('id')])
            ->execute();

        return ($affectedRows > 0) ? $token->getValue() : false;
    }
}
