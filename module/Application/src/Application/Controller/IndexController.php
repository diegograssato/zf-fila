<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 26/04/15
 * Time: 12:01
 */

namespace Application\Controller;

use Application\Job\EmailJob;
use SlmQueue\Queue\QueueInterface;
use Zend\Mvc\Controller\AbstractActionController;


class IndexController extends AbstractActionController
{


    public function indexAction()
    {
        // Do some work
        $email = new EmailJob();
        $email->setTo('john@doe.com')
              ->setSubject('Just hi')
             ->setMessage("Testando......");


        $this->queue("default")->push("EmailJob",  $email);
       // $job->setId(1);
//        $this->queue("default")->push("EmailJob", $job, array(
//            'priority' => 20,
//            'delay'    => 23,
//            'ttr'      => 50
//        ));
    }
}