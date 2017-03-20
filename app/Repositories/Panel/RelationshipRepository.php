<?php

namespace App\Repositories\Panel;

class RelationshipRepository
{

    /**
     * Create associations
     *
     * @param array $data
     * @return object
     */
    /**
     * @param $table
     * @param array $fields
     * @return object
     * 
     */
    public function create($table, array $fields = [])
    {
        try {
            \DB::table($table)->insert($fields);
        } catch (\PDOException $e) {
            return (object)[
                'error' => true,
                'debug' => $e->errorInfo
            ];
        }
        return (object)['error' => false];
    }

    /**
     * Delete associations
     *
     * @param array $data
     * @return object
     */
    public function destroy(array $data = [])
    {
        foreach ($data as $key => $values) {
            try {
                \DB::table($key)->where($values)->delete();
            } catch (\PDOException $e) {
                return (object)[
                    'error' => true,
                    'debug' => $e->errorInfo
                ];
            }
        }
        return (object)['error' => false];
    }

}