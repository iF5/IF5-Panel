<?php

namespace App\Repositories\Panel;

class AssociateRepository
{
    /**
     * @param string $table
     * @param array $fields
     * @return bool
     */
    public function create($table, array $fields = [])
    {
        $result = true;
        try {
            \DB::table($table)->insert($fields);
        } catch (\PDOException $e) {
            if ((int)$e->errorInfo[1] === 1062) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * @param string $table
     * @param array $fields
     */
    public function destroy($table, array $fields = [])
    {
        \DB::table($table)->where($fields)->delete();
    }

}