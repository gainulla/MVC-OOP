<?php

namespace App\Core;

class SessionManager
{
    public function __construct(string $cacheExpire=null, string $cacheLimiter=null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            if ($cacheLimiter !== null) {
                session_cache_limiter($cacheLimiter);
            }
            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire);
            }

            session_start();
        }
    }

    public function get(string $key, bool $remove=false)
    {
        if ($this->has($key)) {
            $sessionData = $_SESSION[$key];

            if ($remove) {
                $this->remove($key);
            }

            return $sessionData;
        }

        return null;
    }

    public function set(string $key, $value): SessionManager
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void
    {
        session_unset();
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }
}
