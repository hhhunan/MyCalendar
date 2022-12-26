<?php

namespace App\Exceptions\BusinessLogicExceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

/**
 * Class CalendarNotFoundException
 * @package App\Exceptions\BusinessLogicExceptions
 */
class CalendarNotFoundException extends BusinessLogicException
{
    /**
     * CalendarNotFoundException constructor.
     * @param int|null $id
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure] public function __construct(
        ?int $id = null,
        string $message = 'Calendar not found',
        int $code = 404,
        Throwable $previous = null
    )
    {
        if ($id) {
            $message .= " by id: $id";
        }

        parent::__construct($message, $code, $previous);
    }
}
