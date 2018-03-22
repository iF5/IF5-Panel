<?php

namespace App\Repositories\Batch;

use App\Http\Traits\CrudTrait;

class RegisterEmployeeRepository
{

    use CrudTrait;

    protected $table = 'register_batch_employees';

    /**
     * @return mixed
     */
    public function findAll()
    {
        return \DB::table($this->table)->where([
            ['status', '=', 0]
        ])->get();
    }


    public function save($data)
    {
        $this->insertBatch($this->table, $data);
    }

    public function updateById($id, array $data = [])
    {
        $this->updateTo($this->table, $data, [
            ['id', '=', $id]
        ]);
    }

}