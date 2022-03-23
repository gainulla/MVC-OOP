<?php

namespace App\Contracts;

interface RInterface
{
    public function fetch($fields=[]): array;

    public function find($id, $fields=[]): object;
}
