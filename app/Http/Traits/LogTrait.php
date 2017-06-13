<?php

namespace App\Http\Traits;

use App\Models\Log;

trait LogTrait
{

    use AuthTrait;

    /**
     * @param string $title
     * @param string $method
     * @param array $data
     */
    protected function saveLog($title, $method, array $data = [])
    {
        Log::create([
            'title' => $title,
            'method' => $method,
            'authorId' => $this->getId(),
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'data' => json_encode($data)
        ]);
    }

}