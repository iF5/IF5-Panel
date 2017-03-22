<?php

namespace App\Http\Validations;


class FormValidate
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $where = [];

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
        $this->table = array_shift($parameters);

        foreach ($parameters as $key => $field) {
            if (preg_match('/^id=/', $field)) {
                $this->whereFieldId($field);
                continue;
            }
            $this->where[] = [
                $field, '=', $fields[$field]
            ];
        }

        return $this->contains();
    }

    /**
     * @param string $fieldId
     * @param string $operator
     */
    private function whereFieldId($fieldId, $operator = '!=')
    {
        $expId = explode('=', $fieldId);
        if ($expId[1]) {
            $this->where[] = [$expId[0], $operator, $expId[1]];
        }
    }

    /**
     * @return bool
     */
    private function contains()
    {
        $stmt = \DB::table($this->table);
        if (count($this->where) > 0) {
            $stmt->where($this->where);
        }
        $this->clear();
        return ($stmt->count() <= 0);
    }

    /**
     * Resets proprieties
     */
    private function clear()
    {
        $this->table = null;
        $this->where = [];
    }

}