<?php

namespace App\Repositories\Panel;

use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Traits\AuthTrait;

class LogRepository extends Log
{

    use AuthTrait;

    private $totalPerPage = 30;

    /**
     * @param integer $id
     * @return mixed
     */
    public function findById($id)
    {
        try {
            return Log::join('users', function ($join) {
                $join->on('users.id', '=', 'logs.userId');
            })->where('logs.id', '=', $id)->first();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param string $date
     * @param string | null $method
     * @return mixed
     */
    public function findByToday($date, $method = null)
    {
        try {
            $stmt = Log::join('users', function ($join) {
                $join->on('users.id', '=', 'logs.userId');
            })->selectRaw('logs.*, users.name')
                ->whereBetween('logs.createdAt', ["{$date} 00:00:00", "{$date} 23:59:59"]);

            if ($method) {
                $stmt->where('logs.method', '=', $method);
            }

            return $stmt->orderBy('logs.createdAt', 'desc')->paginate($this->totalPerPage);

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}