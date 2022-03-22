<?php

namespace App\Contracts;

interface RInterface
{
    public function fetch($models): array;

    public function find($model): object;
}
