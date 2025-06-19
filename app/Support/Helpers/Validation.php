<?php

namespace App\Support\Helpers;

class Validation
{
    public static function generateMessages(array $rules): array
    {
        $messages = [];

        foreach ($rules as $field => $fieldRules) {
            $fieldRulesArray = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($fieldRulesArray as $rule) {
                $ruleName = explode(':', $rule)[0];
                $messages["$field.$ruleName"] = self::getMessageTemplate($ruleName, $field);
            }
        }

        return $messages;
    }

    private static function getMessageTemplate(string $ruleName, string $field): string
    {
        $templates = [
            'required' => 'The :attribute field is required.',
            'required_without_all' => 'The required fields have not been filled in.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field must not be greater than :max characters.',
            'min' => 'The :attribute field must not have less than :min characters.',
            'integer' => 'The :attribute field must be an integer number.',
            'numeric' => 'The :attribute field must be a number.',
            'float' => 'The :attribute field must be a float number.',
            'between' => 'The :attribute field must be between :min and :max.',
            'in' => 'The selected :attribute is invalid.',
            'not_in' => 'The selected :attribute is not allowed.',
            'same' => 'The :attribute and :other must match.',
            'different' => 'The :attribute and :other must be different.',
            'regex' => 'The :attribute format is invalid.',
            'url.regex' => 'The URL must start with "/" and be valid.',
            'array' => 'The :attribute field must be an array.',
            'boolean' => 'The :attribute field must be true or false.',
            'json' => 'The :attribute field must contain a valid JSON string.',
            'exists' => 'Check :attribute and try again.',

            'email' => 'The :attribute must be a valid email address.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'password' => 'The password must meet the required criteria.',
            'unique' => 'Unable to complete the request. Please verify your data.',
            'same' => 'The :attribute must match :other.',

        ];

        $template = $templates[$ruleName] ?? 'The :field has an invalid value.';
        return str_replace(':field', str_replace('_', ' ', $field), $template);
    }
}
