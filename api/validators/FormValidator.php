<?php


class FormValidator
{
    private $errors = [];

    public function validate(array $data, array $formRules = []): void
    {
        foreach ($data as $dataKey => $dataValue) {

            //taking rules an arguments from formRules array
            $rules = $formRules[$dataKey] ?? [];
            foreach ($rules as $rule) {
                //explode to get method and argument(ex. 'min:10')
                $rule = explode(':', $rule);
                $method = $rule[0];//'min:10' -> min
                //argument can be null in some cases
                $argument = $rule[1] ?? null;//'min:10' -> 10
                //prepare method name (ex. 'min:10' will be validateMin() method)
                $validateMethodName = 'validate' . ucfirst($method);

                //run validation method, check if passed, log errors if not
                if (!$this->$validateMethodName($dataValue, $argument)) {
                    $this->errors[$dataKey] = "Must be " . $method . ' ' . $argument;
                }
            }
        }
    }

    public function passed(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validateRequired($value, $argument): bool
    {
        return !empty($value);
    }

    public function validateMin($value, $argument): bool
    {
        return strlen($value) >= (int)$argument;
    }

    public function validateMax($value, $argument): bool
    {
        return strlen($value) <= (int)$argument;
    }
}