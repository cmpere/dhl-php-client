<?php

namespace LiaTec\DhlPhpClient\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class Stack
{
    public function __construct()
    {
    }

    /**
     * Gets mock handler for successfully ratting request
     *
     * @param  array        $data
     * @return HandlerStack
     */
    public static function ok($data = []): HandlerStack
    {
        /** @phpstan-ignore-next-line */
        $self = new static();

        return $self->mock([
            $self->success($data),
        ]);
    }

    /**
     * Create success response
     *
     * @param  array    $data
     * @param  integer  $code
     * @return Response
     */
    public function success($data = [], $code = 200): Response
    {
        return new Response($code, [
            'Content-Type' => 'application/json;charset=utf-8',
        ], json_encode($data));
    }

    /**
     * Create mock handler
     *
     * @param  array        $stackItems
     * @return HandlerStack
     */
    public function mock($stackItems = []): HandlerStack
    {
        return HandlerStack::create(new MockHandler($stackItems));
    }
}
