<?php

namespace App\Repositories\Queue;

class QueueRepository
{

    /**
     * @return mixed
     */
    public function getRegisterEmployee()
    {
        return \DB::table('queue_register_employees')->where([
            ['status', '=', 0]
        ])->get();
    }

}