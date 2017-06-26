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
    public function find($code = null, $cnae = null)
    {
        try {
            if($code !== null){
                $where = 'code = ' . $code;
            }else if($cnae !== null){
                $where = 'cnae like ' . "'%" . $cnae . "%'";
            }

            $stmt = \DB::table(null)->selectRaw('
                code,
                cnae'
            )->from(\DB::raw("cnae"))->whereRaw($where);

            return $stmt->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}