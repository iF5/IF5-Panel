<?php

namespace App\Http\Validations;


class UniqueMultiple
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
    public function has($attribute, $value, $parameters, $validator)
    {
        $data = $validator->getData();
        $this->table = array_shift($parameters);

        foreach ($parameters as $field) {
            if (preg_match('/^id=/', $field)) {
                $this->whereFieldId($field);
                continue;
            }
            $this->where[] = [
                $field, '=', $data[$field]
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
        $data = explode('=', $fieldId);
        if ((int)$data[1]) {
            $this->where[] = [$data[0], $operator, $data[1]];
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