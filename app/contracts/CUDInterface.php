<?php

namespace App\Contracts;

interface CUDInterface
{
    public function save($model): bool;

    public function remove($model): bool;
}
