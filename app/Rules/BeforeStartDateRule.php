<?php

namespace App\Rules;

use App\Models\Calendar;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BeforeStartDateRule implements Rule
{
    private $dateTime;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return auth('api')->check() && (strtotime(($this->dateTime)->subHours(3)) > strtotime(now()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be before less than 3 hours before old  :attribute value.";
    }
}
