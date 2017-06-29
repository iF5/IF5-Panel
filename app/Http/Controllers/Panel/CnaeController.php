<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Repositories\Panel\CnaeRepository;

class CnaeController
{

    /**
     * @var CnaeRepository
     */
    private $cnaeRepository;


    public function __construct(
        CnaeRepository $cnaeRepository
    )
    {
        $this->cnaeRepository = $cnaeRepository;
    }

    public function index(Request $request, $cnae)
    {
        //$this->cnaeRepository->find($code, $cnae);
        return response()->json(
            $this->cnaeRepository->find($cnae)
        );
    }

}
