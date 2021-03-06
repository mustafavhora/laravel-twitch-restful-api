<?php
namespace Skmetaly\TwitchApi\Exceptions;

use Exception;

/**
 * Class RequestRequiresAuthenticationException
 * @package Skmetaly\TwitchApi\Exceptions
 */
class RequestRequiresAuthenticationException extends Exception {

    /**
     *
     */
    public function __construct()
    {
        $this->message = 'This request requires authentication';
    }
}