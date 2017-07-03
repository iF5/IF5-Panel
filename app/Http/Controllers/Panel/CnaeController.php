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
        $arr = $this->cnaeRepository->find($cnae);

        foreach($arr as &$values){
            $values->name = html_entity_decode($values->name);
        }

        return response()->json(
            $arr
        );
    }

}
