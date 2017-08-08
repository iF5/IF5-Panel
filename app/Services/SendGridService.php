<?php

namespace App\Services;

use SendGrid;

class SendGridService
{
    /**
     * @const string
     */
    const API_KEY = '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';

    /**
     * @var string
     */
    private $senderName = 'IF5 Administrador';

    /**
     * @var string
     */
    private $senderEmail = 'admin@if5.com.br';

    /**
     * @var string
     */
    private $receiverName;

    /**
     * @var string
     */
    private $receiverEmail;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $content;

    /**
     * @var bool
     */
    private $isTextHtml = false;

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     * @return $this
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param string $senderEmail
     * @return $this
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * @param string $receiverName
     * @return $this
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverEmail()
    {
        return $this->receiverEmail;
    }

    /**
     * @param string $receiverEmail
     * @return $this
     */
    public function setReceiverEmail($receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsTextHtml()
    {
        return $this->isTextHtml;
    }

    /**
     * @param bool $isTextHtml
     * @return $this
     */
    public function setIsTextHtml($isTextHtml)
    {
        $this->isTextHtml = $isTextHtml;
        return $this;
    }

    /**
     * @return bool
     */
    public function send()
    {
        $from = new SendGrid\Email($this->senderName, $this->senderEmail);
        $to = new SendGrid\Email($this->receiverName, $this->receiverEmail);

        $textType = ((boolean)$this->isTextHtml) ? 'text/html' : 'text/plain';
        $content = new SendGrid\Content($textType, $this->content);
        $mail = new SendGrid\Mail($from, $this->subject, $to, $content);
        $sg = new \SendGrid(self::API_KEY);

        $response = $sg->client->mail()->send()->post($mail);
        return (in_array((int)$response->statusCode(), [200, 202])) ? true : false;
    }

}