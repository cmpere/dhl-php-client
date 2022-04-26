<?php

namespace LiaTec\DhlPhpClient;

abstract class Manager
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }
}
