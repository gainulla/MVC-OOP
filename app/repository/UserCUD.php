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

        $this->db->set([
            'username'      => $user->attr('username'),
            'email'         => $user->attr('email'),
            'passwordHash'  => $user->attr('passwordHash')
        ]);

        if ($user->attr('id')) {
            $this->db->where(['id' => $user->attr('id')]);
        }

        $affectedRows = $this->db->execute()->rowCount();

        $this->db->reset();

        return $affectedRows > 0;
    }

    public function remove($user): bool
    {
        // remove user ...
    }

    public function startPasswordReset($user, Token $token)
    {
        $hashedToken = $token->generate()->getHash();
        $passwordResetToken = $token->getValue();
        $expiryTime = date('Y-m-d H:i:s', time() + 60 * 10); // 10 minutes

        $affectedRows = $this->db
            ->update('users')
            ->set([
                'passwordResetHash'      => $hashedToken,
                'passwordResetExpiresAt' => $expiryTime
            ])
            ->where(['id' => $user->attr('id')])
            ->execute()
            ->debug()
            ->rowCount();

        $this->db->reset();

        return ($affectedRows > 0) ? $passwordResetToken : false;
    }
}
