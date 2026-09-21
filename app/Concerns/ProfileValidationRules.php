<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null): array
    {
        return [
            'first_name' => $this->firstNameRules(),
            'last_name' => $this->lastNameRules(),
            'username' => $this->usernameRules($userId),
            'email' => $this->emailRules($userId),
            'bio' => $this->bioRules(),
            'gender' => $this->genderRules(),
            'date_of_birth' => $this->dateOfBirthRules(),
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function firstNameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user bios.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function bioRules(): array
    {
        return ['nullable', 'string', 'max:1000'];
    }

    /**
     * Get the validation rules used to validate user genders.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function genderRules(): array
    {
        return ['nullable', 'string', 'max:50'];
    }

    /**
     * Get the validation rules used to validate user date of birth.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function dateOfBirthRules(): array
    {
        return ['nullable', 'date', 'before:today'];
    }

    /**
     * Get the validation rules used to validate user last names.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function lastNameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate usernames.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function usernameRules(?int $userId = null): array
    {
        return [
            'required',
            'string',
            'max:255',
            $userId === null
                ? Rule::unique(User::class, 'username')
                : Rule::unique(User::class, 'username')->ignore($userId),
        ];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function emailRules(?int $userId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            $userId === null
                ? Rule::unique(User::class)
                : Rule::unique(User::class)->ignore($userId),
        ];
    }
}
