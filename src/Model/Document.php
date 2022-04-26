<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Document extends Model
{
    protected $bindings = [
        'imageFormat' => 'string',
        'content'     => 'string',
        'typeCode'    => 'string',
    ];
}
