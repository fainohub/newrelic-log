<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class MessageDomainException extends \DomainException
{
    protected $message;

    public function __construct($message = "", $code = 500)
    {
        $this->message = $message;
        parent::__construct($message, $code);
    }

    public function getCustomMessage()
    {
        return $this->message;
    }
}