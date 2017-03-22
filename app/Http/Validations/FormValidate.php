<?php

namespace App\Http\Validations;


class FormValidate
{

    /**
     * Validate fields multiple unique
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param object $validator
     * @return bool
     */
    public function uniqueMultiple($attribute, $value, $parameters, $validator)
    {
        $fields = $validator->getData();
        $table = array_shift($parameters);
        $stmt = \DB::table($table);

        foreach ($parameters as $key => $field) {
            $stmt->where($field, '=', $fields[$field]);
        }

        return ($stmt->count() === 0);
    }

}