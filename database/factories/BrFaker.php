<?php

    namespace Database\Factories;

    trait BrFaker {
        public function cpf(): string {

            $cpf = $this->faker->unique()->numerify('#########');
            $cpf .= $this->calculateVerificationDigit($cpf);

            return $cpf;
        }

        private function calculateVerificationDigit($base) {

            $firstDigit  = $this->calculateDigit($base, 10, 11);
            $secondDigit = $this->calculateDigit($base.$firstDigit, 11, 11);

            return $firstDigit.$secondDigit;
        }

        private function calculateDigit($base, $length, $weight) {

            $sum = 0;

            for ($i = 1; $i <= $length; $i++) {
                if (isset($base[$i - 1])) {
                    $sum += $base[$i - 1] * ($weight - $i);
                }
            }

            $remainder = $sum % 11;

            return $remainder < 2 ? 0 : 11 - $remainder;
        }

        public function celular(): string {

            return $this->faker->numerify('(##) 9####-####');
        }
    }
