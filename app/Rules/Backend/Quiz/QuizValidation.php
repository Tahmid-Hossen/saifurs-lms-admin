<?php

namespace App\Rules\Backend\Quiz;

use Illuminate\Contracts\Validation\Rule;
use App\Services\UtilityService;

class QuizValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if(isset(UtilityService::$quizType[$value])){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Please, Don't be Over-smart";
    }
}
