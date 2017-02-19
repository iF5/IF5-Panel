<?php

namespace App\Services;

class ResultAndLogService
{
    private $returnStructure = array(
        'result' => 0,
        'data' => '',
        'error' => ''
    );

    public function result($bool, $data=false, $error=false)
    {
        if($bool){
            $this->returnStructure['result'] = 1;
        }
        if($data){
            $this->returnStructure['data'] = $data;
        }
        if($error){
           $error = $this->hideSqlMessage($error);
           $this->returnStructure['error'] = $error;
        }

        $this->printJson($this->returnStructure);
    }

    private function hideSqlMessage($msgError)
    {
        $pos = strpos($msgError, "SQL:");
        if($pos){
            $msgError = substr($msgError, 0, $pos) . "...";
        }
        return $msgError;
    }

    private function printJson($arrayData)
    {
        print json_encode($arrayData);
    }
}
