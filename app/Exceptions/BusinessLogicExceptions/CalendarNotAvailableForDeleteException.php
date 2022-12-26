<?php

namespace App\Exceptions\BusinessLogicExceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

/**
 * Class CalendarNotAvailableForDeleteException
 * @package App\Exceptions\BusinessLogicExceptions
 */
class CalendarNotAvailableForDeleteException extends BusinessLogicException
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
        string $message = 'Calendar Not Available For Delete',
        int $code = 422,
        Throwable $previous = null
    )
    {
        if ($id) {
            $message .= " by id: $id";
        }

        parent::__construct($message, $code, $previous);
    }
}
