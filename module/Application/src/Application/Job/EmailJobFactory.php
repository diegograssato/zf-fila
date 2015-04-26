<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 26/04/15
 * Time: 13:23
 */

namespace Application\Job;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmailJobFactory  implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $services)
    {
        //$transport = $sl->get('MyEmailTransport');
        return new EmailJob();
    }
}