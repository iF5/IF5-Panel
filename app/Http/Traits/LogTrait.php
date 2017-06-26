<?php

namespace App\Http\Traits;

use App\Models\Log;

trait LogTrait
{

    /**
     * @param string $title
     * @param string $method
     * @param array $data
     */
    protected function createLog($title, $method, array $data = [])
    {
        Log::create([
            'title' => $title,
            'method' => $method,
            'userId' => \Auth::user()->id,
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'data' => json_encode($data)
        ]);
    }

}