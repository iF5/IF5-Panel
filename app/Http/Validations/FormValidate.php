<?php

namespace App\Http\Validations;


class Form
{

    public function uniqueMultiple($attribute, $value, $parameters, $validator)
    {
        // Get the other fields
        $fields = $validator->getData();

        // Get table name from first parameter
        $table = array_shift($parameters);

        // Build the query
        $query = \DB::table($table);

        // Add the field conditions
        foreach ($parameters as $i => $field) {
            $query->where($field, $fields[$field]);
        }

        // Validation result will be false if any rows match the combination
        return ($query->count() === 0);

    }

}