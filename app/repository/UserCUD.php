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
            ->execute()
            ->rowCount();

        $this->db->reset();

        return ($affectedRows > 0) ? $token->getValue() : false;
    }

    /////////////////////////////////////////////////////////////////
    public function resetPassword($password)
	{
		$this->password = $password;
		$this->validate();

		if (empty($this->errors)) {
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);

			$sql = 'UPDATE users
							SET password_hash = :password_hash,
									password_reset_hash = NULL,
									password_reset_expires_at = NULL
							WHERE id = :id';

			$db = static::connect();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

			return $stmt->execute();
		}

		return false;
	}
}
