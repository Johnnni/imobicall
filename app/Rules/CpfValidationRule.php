<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $value);

        if (strlen($cpf) != 11) {
            $fail("CPF inválido.");
            return;
        }

        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--)
            $sum += $cpf[$i] * $j;
        $rest = $sum % 11;
        if ($cpf[9] != ($rest < 2 ? 0 : 11 - $rest)) {
            $fail("CPF inválido.");
            return;
        }

        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--)
            $sum += $cpf[$i] * $j;
        $rest = $sum % 11;
        if ($cpf[10] != ($rest < 2 ? 0 : 11 - $rest)) {
            $fail("CPF inválido.");
        }
    }
}
