<?php

namespace App\Repositories\Panel;

class RelationshipRepository
{

    /**
     * Create associations
     *
     * @param string $table
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
                'info' => $e->errorInfo
            ];
        }
        return (object)['error' => false];
    }

    /**
     * Delete associations
     *
     * @param string $table
     * @param array $whereFields
     * @return object
     */
    public function destroy($table, array $whereFields = [])
    {
        try {
            $stmt = \DB::table($table);
            if (count($whereFields) > 0) {
                $stmt->where($whereFields);
            }
            $stmt->delete();
        } catch (\PDOException $e) {
            return (object)[
                'error' => true,
                'info' => $e->errorInfo
            ];
        }

        return (object)['error' => false];
    }

}