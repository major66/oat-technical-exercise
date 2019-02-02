<?php declare(strict_types=1);

namespace Oat\UserApi\Domain\User\Exception;

use RuntimeException;
use Throwable;

class UserNotFoundException extends RuntimeException
{
    public function __construct(string $message = '', Throwable $previous = null)
    {
        parent::__construct($message ?: 'User not found.', 404, $previous);
    }
}