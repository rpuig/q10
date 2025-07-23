<?php
namespace App\CustomValidation;
class CustomRules 
{
    public function even($value): bool
    {
        return (int) $value % 2 === 0;
    }

  




    public function is_unique_username(string $str, string $fields, array $data): bool
    {
        [$table, $field, $currentUsername] = explode(',', $fields);

        $model = model('App\Models\User');

        // Check if the new username is the same as the current username
        if ($str === $currentUsername) {
            return true;
        }

        // Check if the new username is unique
        return !$model->where($field, $str)->first();
    }
}