<?php

namespace App\Services;

class CsvService
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var array
     */
    private $data = [
        'error' => false,
        'message' => 'No errors were found',
        'body' => []
    ];

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
     * @param string $message
     * @return array
     */
    private function toError($message)
    {
        return [
            'error' => true,
            'message' => $message,
            'body' => []
        ];
    }

    /**
     * @return bool
     */
    private function fileExists()
    {
        if (!file_exists($this->filePath)) {
            $this->data = $this->toError('File not found');
            return false;
        }
        return true;
    }

    /**
     * Load in memory to array
     */
    public function loadInMemory()
    {
        if ($this->fileExists()) {
            $fp = fopen($this->filePath, 'r');
            $csv = [];
            while (($line = fgetcsv($fp)) !== false) {
                $csv[] = $line[0];
            }
            fclose($fp);

            $total = count($csv);
            if ($total < 2) {//requires at least two lines, one of head and one of body
                $this->data = $this->toError('No records found');
                return;
            }

            $fields = array_values(explode(';', $csv[0]));
            for ($i = 1; $i < $total; $i++) {
                $row = explode(';', $csv[$i]);
                $this->data['body'][] = array_combine($fields, array_values($row));
            }
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}