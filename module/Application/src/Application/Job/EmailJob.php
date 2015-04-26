<?php

namespace Application\Job;

use SlmQueue\Job\AbstractJob;

class EmailJob extends AbstractJob
{
    private $to;
    private $subject;
    private $message;
    public function execute()
    {

        //throw new Exception\BuryableException(array('priority' => 10));
        $payload = $this->getContent();
        echo "\n";
        var_dump($payload);
        //SlmQueue/Queue/AbstractQueue.phpecho "\nID ". $payload->getId();

        //var_dump($payload['message']);
//        var_dump($payload->getTo());
//        var_dump($payload->getMessage());
        echo "\n";

    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }




}