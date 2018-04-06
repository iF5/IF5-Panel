<?php

namespace App\Http\Traits;

trait StmtTrait 
{

    public function insertIgnore($table, array $data = [])
    {
        $indexes = [];
        foreach ($data as $row) {
            if (is_array($row)) {
                $columns = implode(',', array_keys($row));
                $values = substr(str_repeat('?,', count($row)), 0, -1);
                $template = sprintf('INSERT IGNORE INTO %s (%s) VALUES (%s)', $table, $columns, $values);
                $indexes[] = \DB::insert($template, array_values($row));
            }
        }

        return $indexes;
    }

}