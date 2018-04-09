<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\CnaeRepository;

class CnaeController
{

    /**
     * @var CnaeRepository
     */
    private $cnaeRepository;

    /**
     * CnaeController constructor.
     * @param CnaeRepository $cnaeRepository
     */
    public function __construct(CnaeRepository $cnaeRepository)
    {
        $this->cnaeRepository = $cnaeRepository;
    }

    /**
     * @param $cnae
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($cnae)
    {
        $data = $this->cnaeRepository->find($cnae);
        foreach ($data as &$values) {
            $values->name = html_entity_decode($values->name);
        }

        return response()->json($data);
    }

}
