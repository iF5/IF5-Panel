<?php

namespace App\Models\Crud;

trait Create
{

    /**
     * @param array $data
     * @return object
     */
    private function fieldsAndValues(array $data = [])
    {
        $values = '';
        foreach ($data as $key => $value) {
            $values .= sprintf("('%s'),", implode("', '", array_values($value)));
        }
        return (object)[
            'fields' => sprintf('(%s)', implode(',', array_keys(end($data)))),
            'values' => substr($values, 0, -1)
        ];
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    protected function insertIgnoreBatch($table, array $data = [])
    {
        try {
            if (count($data) <= 0) {
                return false;
            }

            $row = $this->fieldsAndValues($data);
            \DB::insert("INSERT IGNORE INTO {$table} {$row->fields} VALUES {$row->values};");
            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}