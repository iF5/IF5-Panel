<?php

namespace App\Http\Traits;

trait CrudTrait
{
    /**
     * @param array $data
     * @return object
     */
    /*private function fieldsAndValues(array $data = [])
    {
        $values = '';
        $bind = [];
        foreach ($data as $key => $value) {
            //$row = str_repeat('?,', count($value));
            //$values .= sprintf("(%s),", substr($row, 0, -1));
            //$bind[] = array_values($value);

            $map = array_map(function ($v) {
                return \DB::getPdo()->quote($v);
            }, array_values($value));

            $bind[] = $map;


        }

        dd($bind);

        return (object)[
            'fields' => sprintf('(%s)', implode(',', array_keys(end($data)))),
            'values' => substr($values, 0, -1),
            'bind' => $bind
        ];
    }*/

    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    /*protected function insertIgnoreBatch($table, array $data = [])
    {
        try {
            if (count($data) <= 0) {
                return false;
            }

            $row = $this->fieldsAndValues($data);
            //dd($row);

            \DB::insert("INSERT IGNORE INTO {$table} {$row->fields} VALUES {$row->values};", $row->bind);
            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }*/

    /**
     * @param string $message
     * @return array
     */
    protected function errorOrFail($message)
    {
        return (object)[
            'error' => true,
            'message' => $message
        ];
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    protected function insertBatchGetId($table, array $data = [])
    {
        try {
            if (!count($data)) {
                return $this->errorOrFail('Data not found');
            }

            $all = [];
            foreach ($data as $key => $values) {
                $all[] = \DB::table($table)->insertGetId($values);
            }
            return (object)['error' => false, 'all' => $all];
        } catch (\Exception $e) {
            return $this->errorOrFail($e->getMessage());
        }
    }


    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    protected function insertBatch($table, array $data = [])
    {
        try {
            if (!count($data)) {
                return $this->errorOrFail('Data not found');
            }

            \DB::table($table)->insert($data);
            return (object)['error' => false];

        } catch (\Exception $e) {
            return $this->errorOrFail($e->getMessage());
        }
    }
}