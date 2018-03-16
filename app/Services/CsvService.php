<?php

namespace App\Services;

class CsvService
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $separator = ';';

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     * @return $this
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * @param bool $error
     * @param string $message
     * @param array $data
     * @return array
     */
    private function response($error = false, $message, array $data = [])
    {
        return [
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @return array
     */
    private function parse()
    {
        $fp = fopen($this->filePath, 'r');
        $rows = [];
        while (($line = fgetcsv($fp)) !== false) {
            if (count($line[0]) > 0) {
                $rows[] = $line[0];
            }
        }
        fclose($fp);
        return $rows;
    }

    /**
     * @return array
     */
    public function get()
    {
        try {
            if (!file_exists($this->filePath)) {
                return $this->response(true, 'File not found');
            }

            $rows = $this->parse();
            $total = count($rows);
            if ($total < 2) {//requires at least two lines, one of head and one of body
                return $this->response(true, 'No records found');
            }

            $fields = array_values(explode($this->separator, $rows[0]));
            $data = [];
            for ($i = 1; $i < $total; $i++) {
                $row = explode($this->separator, $rows[$i]);
                $data[] = array_combine($fields, array_values($row));
            }

            return $this->response(false, 'Csv reading done successfully', $data);
        } catch (\Exception $e) {
            return $this->response(true, 'Error in csv formatting');
        }
    }

}