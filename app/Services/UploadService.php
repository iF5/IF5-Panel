<?php

namespace App\Services;

class UploadService
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var array
     */
    private $allowedExtensions;

    /**
     * @var string
     */
    private $allowedExtensionsMessage;

    /**
     * @var int
     */
    private $maximumSize;

    /**
     * @var string
     */
    private $maximumSizeMessage;

    /**
     * @var array
     */
    private $response = [
        'error' => false,
        'message' => null
    ];

    /**
     * @param string $dir
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        if (!file_exists($this->dir)) {
            mkdir($this->dir, 0777, true);
        }

        return $this;
    }

    /**
     * @param array $allowedExtensions
     * @param null | string $message
     * @return $this
     */
    public function setAllowedExtensions(array $allowedExtensions = [], $message = null)
    {
        $this->allowedExtensions = $allowedExtensions;
        $this->allowedExtensionsMessage = $message;
        return $this;
    }

    /**
     * @param int $maximumSize
     * @param null | string $message
     * @return $this
     */
    public function setMaximumSize($maximumSize, $message = null)
    {
        $this->maximumSize = (int)$maximumSize;
        $this->maximumSizeMessage = $message;
        return $this;
    }

    /**
     * @param mixed $file
     * @return bool
     */
    private function validateExtension($file)
    {
        if (!$this->allowedExtensions) {
            return true;
        }

        if (!in_array($file->getClientOriginalExtension(), $this->allowedExtensions)) {
            $this->response = [
                'error' => true,
                'message' => $this->allowedExtensionsMessage
            ];
            return false;
        }
        return true;
    }

    /**
     * @param mixed $file
     * @return bool
     */
    private function validateSize($file)
    {
        if (!$this->maximumSize) {
            return true;
        }

        if ($file->getClientSize() > $this->maximumSize) {
            $this->response = [
                'error' => true,
                'message' => $this->maximumSizeMessage
            ];
            return false;
        }
        return true;
    }

    /**
     * @param mixed $file
     * @param null | string $customName
     * @param null | string $message
     * @return array|object
     */
    public function move($file, $customName = null, $message = null)
    {
        if (!$this->validateExtension($file)) {
            return (object)$this->response;
        }

        if (!$this->validateSize($file)) {
            return (object)$this->response;
        }

        $name = ($customName) ? $customName : $file->getClientOriginalName();
        if (!$file->move($this->dir, $name)) {
            return (object)$this->response = [
                'error' => true,
                'message' => sprintf('Internal error trying to upload file: %s', $file->getClientOriginalName())
            ];
        }

        $this->response['message'] = $message;
        return (object)$this->response;
    }

}