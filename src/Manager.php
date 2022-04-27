<?php

namespace LiaTec\DhlPhpClient;

abstract class Manager
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Get the value of client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @return self
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }
}
