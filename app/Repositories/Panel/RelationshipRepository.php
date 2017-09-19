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
     * Update associations
     *
     * @param string $table
     * @param array $fields
     * @param array $where
     * @return object
     */
    public function update($table, array $fields = [], array $where = [])
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

    /**
     * Delete associations
     *
     * @param string $table
     * @param array $where
     * @return object
     */
    public function destroy($table, array $where = [])
    {
        try {
            $stmt = \DB::table($table);
            if (count($where) > 0) {
                $stmt->where($where);
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