<?php

namespace App\Core\Validator;

class Validator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Проверяет данные по заданным правилам
     * @param array $data Данные для проверки (например, ['name' => 'John'])
     * @param array $rules Правила валидации (например, ['name' => 'required,min:3,max:255'])
     * @return bool true, если валидация прошла успешно, иначе false
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $ruleString) {
            $rulesList = explode('|', $ruleString);

            foreach ($rulesList as $rule) {
                $this->applyRule($field, $data[$field] ?? null, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * Применяет одно правило к полю
     * @param string $field Название поля
     * @param mixed $value Значение поля
     * @param string $rule Правило (например, "required" или "min:3")
     */
    private function applyRule(string $field, $value, string $rule): void
    {
        $params = explode(':', $rule, 2);
        $ruleName = $params[0];
        $ruleValue = $params[1] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->errors[$field][] = "Поле $field обязательно для заполнения.";
                }
                break;

            case 'min':
                if (strlen($value) < $ruleValue) {
                    $this->errors[$field][] = "Поле $field должно содержать минимум $ruleValue символов.";
                }
                break;

            case 'max':
                if (strlen($value) > $ruleValue) {
                    $this->errors[$field][] = "Поле $field должно содержать максимум $ruleValue символов.";
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "Поле $field должно быть действительным email-адресом.";
                }
                break;

            // Можно добавить другие правила (например, 'numeric', 'regex', 'confirmed')
            default:
                $this->errors[$field][] = "Неизвестное правило валидации: $ruleName";
        }
    }

}