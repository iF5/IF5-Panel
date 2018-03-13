<?php

namespace App\Services;

class CsvLoad
{

    public function to()
    {
        $file = fopen('test.csv', 'r');

        $array = [];
        while (($line = fgetcsv($file)) !== false) {
            $array[] = $line[0];
        }
        fclose($file);

        $header = array_values(explode(';', $array[0]));

        $body = [];
        $total = count($array);
        for($i = 1; $i < $total; $i++) {
            $row = explode(';', $array[$i]);
            $body[] = array_combine($header, array_values($row));
        }

        print_r($body);
    }

}