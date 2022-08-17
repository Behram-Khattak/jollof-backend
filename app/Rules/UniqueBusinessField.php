<?php

namespace App\Rules;

use App\Models\Business;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueBusinessField implements Rule
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private string $column;

    /**
     * Create a new rule instance.
     *
     * @param        $user
     * @param string $column
     */
    public function __construct($user, string $column)
    {
        $this->user = $user;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Business::where('owner_id', '!=', $this->user->id)
            ->where($this->column, $value)
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute belongs to another business';
    }
}
