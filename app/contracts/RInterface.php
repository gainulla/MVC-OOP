<?php

namespace App\Contracts;

interface RInterface
{
    /**
     * @return array | NULL
     */
    public function fetch($models);

    /**
     * @return object | NULL
     */
    public function find($model);
}
