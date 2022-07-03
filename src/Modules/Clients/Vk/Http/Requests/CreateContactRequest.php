<?php

namespace Modules\Clients\Vk\Http\Requests;

use App\Validation\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{
    /**
     * @return  array<string, array<int, PhoneRule|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:contacts,phone', new PhoneRule()],
        ];
    }
}
