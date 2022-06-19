<?php


namespace App\Validation\Rules;

use App\Helpers\PhoneHelper;
use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    public ?string $pattern = '/^([7|8])(\d{10})$/';

    /**
     * @var null|mixed
     */
    protected $valueRaw = null;

    /**
     * @param string|mixed $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->valueRaw = $value;
        return preg_match($this->pattern, PhoneHelper::cleanPhone($value));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('validation.phone');
    }
}
