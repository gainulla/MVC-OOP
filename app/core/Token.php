<?php

namespace App\Core;

class Token
{
	private $token;
	private $secret_key;

	public function __construct(string $secretKey)
	{
		$this->secret_key = $secretKey;
	}

	public function generate($tokenValue = null)
	{
		if ($tokenValue) {
			$this->token = $tokenValue;
		} else {
            // 16 bytes = 128 bits = 32 hex characters
			$this->token = bin2hex(random_bytes(16));
		}

		return $this;
	}

	public function getValue()
	{
		return $this->token;
	}

	public function getHash()
	{
        // sha256 = 64 chars
		return hash_hmac('sha256', $this->token, $this->secret_key);
	}
}
