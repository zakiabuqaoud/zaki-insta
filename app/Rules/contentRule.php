<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class contentRule implements Rule
{
    protected $words;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        $this->words = $words;
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
        foreach ($this->words as $word) {
            if (strpos($value, $word) !== false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you not can use ' . implode(',', $this->words);
    }
}
