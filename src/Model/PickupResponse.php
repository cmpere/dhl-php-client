<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class PickupResponse extends Model
{
    protected $bindings = [
        'dispatchConfirmationNumbers' => 'array',
        'readyByTime'                 => 'string',
        'nextPickupDate'              => 'string',
        'warnings'                    => 'array',
    ];
}
