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
     * @param bool $error
     * @param array $args
     * @return object
     */
    protected function response($message, $error = false, array $args = [])
    {
        return (object)array_merge($args, [
            'error' => $error,
            'message' => $message
        ]);
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
                return $this->response('Data not found', true);
            }

            $all = [];
            foreach ($data as $key => $values) {
                $all[] = \DB::table($table)->insertGetId($values);
            }

            return $this->response('Success', false, ['all' => $all]);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), true);
        }
    }

    /**
     * @param string $table
     * @param array $data
     * @return object
     */
    protected function insertBatch($table, array $data = [])
    {
        try {
            if (!count($data)) {
                return $this->response('Data not found', true);
            }

            \DB::table($table)->insert($data);
            return $this->response('Success');
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), true);
        }
    }

    public function updateTo($table, array $fields = [], array $where = [])
    {
        try {
            $stmt = \DB::table($table);
            if (count($where) > 0) {
                $stmt->where($where);
            }
            $stmt->update($fields);
        } catch (\PDOException $e) {
            return (object)[
                'error' => true,
                'info' => $e->errorInfo
            ];
        }
        return (object)['error' => false];
    }

}