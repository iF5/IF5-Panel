<?php

namespace App\Services;

class CsvService
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var int
     */
    private $length = null;

    /**
     * @var string
     */
    private $delimiter = ';';

    /**
     * @var string
     */
    private $enclosure = null;

    /**
     * @var string
     */
    private $escape = null;

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
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return $this
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     * @return $this
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
        return $this;
    }

    /**
     * @return string
     */
    public function getEscape()
    {
        return $this->escape;
    }

    /**
     * @param string $escape
     * @return $this
     */
    public function setEscape($escape)
    {
        $this->escape = $escape;
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
        return (object)[
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
        while (($line = fgetcsv($fp, $this->length, $this->delimiter)) !== false) {
            if (count($line[0]) > 0) {
                $rows[] = $line;
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
            if ($total < 2 || count($rows[0]) < 2) {//requires at least two lines, one of head and one of body
                return $this->response(true, 'No records found');
            }

            $columns = array_first($rows);
            $data = [];
            for ($i = 1; $i < $total; $i++) {
                $data[] = array_combine(array_values($columns), array_values($rows[$i]));
            }
            return $this->response(false, 'Csv reading done successfully', $data);

        } catch (\Exception $e) {
            return $this->response(true, 'Error in csv formatting');
        }
    }

}