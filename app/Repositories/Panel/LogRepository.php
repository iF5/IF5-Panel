<?php

namespace App\Repositories\Panel;

use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Traits\AuthTrait;

class LogRepository extends Log
{

    use AuthTrait;

    private $totalPerPage = 20;

    /**
     * @param integer $id
     * @return mixed
     */
    public function findById($id)
    {
        try {
            return Log::join('users', function ($join) {
                $join->on('users.id', '=', 'logs.userId');
            })->selectRaw('
                    logs.*,
                    users.name AS userName,
                    users.email
                ')
                ->where('logs.id', '=', $id)
                ->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function findByToday($date)
    {
        try {
            return Log::join('users', function ($join) {
                $join->on('users.id', '=', 'logs.userId');
            })->selectRaw('logs.*, users.name AS userName')
                ->whereBetween('logs.createdAt', ["{$date} 00:00:00", "{$date} 23:59:59"])
                ->orderBy('logs.createdAt', 'desc')
                ->paginate($this->totalPerPage);

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}