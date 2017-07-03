<?php

namespace App\Repositories\Panel;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Traits\AuthTrait;

class CnaeRepository
{

    use AuthTrait;

    /**
     * @param null $code
     * @param null $cnae
     * @return mixed
     */
    public function find($cnae)
    {
        try {

            $where = 'cnae like ' . "'%" . $cnae . "%'";


            $stmt = \DB::table(null)->selectRaw('
                code as id,
                cnae as name'
            )->from(\DB::raw("cnae"))->whereRaw($where);

            return $stmt->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}