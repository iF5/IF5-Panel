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
    protected function forward($message, $error = false, $data = [])
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
     * @param string $orderBy
     * @param bool $limit
     */
    private function fetch($table, array $where = [], $orderBy = 'ASC', $limit = false)
    {
        $stmt = \DB::table($table);
        if (count($where) > 0) {
            $stmt->where($where);
        }

        if ($orderBy) {
            $stmt->orderBy('id', $orderBy);
        }

        if ($limit) {
            $stmt->take($limit);
        }

        return $stmt;
    }

    /**
     * @param string $table
     * @param array $where
     * @param string $orderBy
     * @param bool $limit
     * @return object
     */
    public function findAll($table, array $where = [], $orderBy = 'ASC', $limit = false)
    {
        try {
            return $this->forward(
                'Success', false, $this->fetch($table, $where, $orderBy, $limit)->get()
            );
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
    }

    /**
     * @param string $table
     * @param array $where
     * @return object
     */
    public function first($table, array $where = [])
    {
        try {
            return $this->forward(
                'Success', false, $this->fetch($table, $where, false, false)->first()
            );
        } catch (\PDOException $e) {
            return $this->forward($e->errorInfo, true);
        }
    }

    /**
     * Create associations
     *
     * @param string $table
     * @param array $columns
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