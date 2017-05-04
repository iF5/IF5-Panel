<?php

namespace App\Repositories\Panel;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotificationRepository
{

    /**
     * @param string $table
     * @param int $status
     * @return mixed
     */
    public function countByStatus($table, $status = 0)
    {
        try {
            return \DB::table($table)
                ->where('status', '=', $status)
                ->count();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}