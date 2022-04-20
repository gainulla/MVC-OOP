<?php

namespace App\Contracts;

interface RInterface
{
    public function fetch($fields=[]); // mixed

    public function find($id, $fields=[]); // mixed
}
