<?php

namespace LiaTec\DhlPhpClient\Credential;

use Exception;
use LiaTec\Http\Credential;

/**
 * @property boolean $test
 * @property string  $APIKey
 * @property string  $APISecret
 */
class DHLBasicAuthCredential extends Credential
{
    /**
     * Modifies request headers
     *
     * @return void
     * @throws Exception
     */
    public function request()
    {
        $this->header('Message-Reference', bin2hex(random_bytes(16)));
        $this->header('Message-Reference-Date', date('D, j M Y H:i:s e'));
    }

    /**
     * Gets API Production status
     *
     * @return bool
     */
    public function inProduction(): bool
    {
        /** @phpstan-ignore-next-line */
        if (is_null($this->test)) {
            return false;
        }

        return !$this->test;
    }

    /**
     * @return array
     */
    public function getTokenRequestParameters(): array
    {
        return [
            'username' => $this->APIKey,
            'password' => $this->APISecret,
        ];
    }
}
