<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function transList($request);
    public function store($data, $type);
}
