<?php

namespace App\Repositories\Panel;

class RelationshipRepository
{

    /**
     * @param string $message
     * @param bool $error
     * @param array $data
     * @return object
     */
    protected function forward($message, $error = false, array $data = [])
    {
        return (object)[
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @param string $table
     * @param array $where
     * @return object
     */
    public function findAll($table, array $where = [])
    {
        try {
            $stmt = \DB::table($table);
            if (count($where) > 0) {
                $stmt->where($where);
            }
            return $this->forward('Success', false, $stmt->get());
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
    }

    /**
     * Create associations
     *
     * @param string $table
     * @param array $fields
     * @return object
     */
    public function create($table, array $columns = [])
    {
        try {
            \DB::table($table)->insert($columns);
            return $this->forward('Success', false);
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
    }

    /**
     * Update associations
     *
     * @param string $table
     * @param array $columns
     * @param array $where
     * @return object
     */
    public function update($table, array $columns = [], array $where = [])
    {
        try {
            $stmt = \DB::table($table);
            if (count($where) > 0) {
                $stmt->where($where);
            }
            $stmt->update($columns);
            return $this->forward('Success', false);
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
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
            return $this->forward('Success', false);
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
    }

}