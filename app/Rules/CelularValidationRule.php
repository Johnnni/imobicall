<?php

    namespace App\Rules;

    use Closure;
    use Illuminate\Contracts\Validation\ValidationRule;

    class CelularValidationRule implements ValidationRule {
        /**
         * Run the validation rule.
         *
         * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
         */
        public function validate(string $attribute, mixed $value, Closure $fail): void {

            $value = preg_replace('/[^0-9]/', '', $value);

            if (strlen($value) !== 11) {
                $fail("O campo $attribute deve ter 11 dígitos.");
            }
        }
    }
