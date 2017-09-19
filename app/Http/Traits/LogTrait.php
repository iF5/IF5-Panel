<?php

namespace App\Http\Traits;

use App\Models\Log;
use Illuminate\Http\Request;

trait LogTrait
{
    /**
     * @return null
     */
    protected function logTitle()
    {
        return null;
    }

    /**
     * @param string $method
     * @param array $data
     */
    protected function createLog($method, array $data = [])
    {
        Log::create([
            'title' => $this->logTitle(),
            'method' => $method,
            'userId' => \Auth::user()->id,
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'data' => json_encode($data)
        ]);
    }

}