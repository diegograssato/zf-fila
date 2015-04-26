<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 26/04/15
 * Time: 19:15
 */

namespace Application\Command;

use Application\Job\EmailJob;
use Zend\Mvc\Controller\AbstractActionController;
use SlmQueue\Queue\QueueInterface;
use Zend\Console\ColorInterface as Color;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App as RatchetApp;

class ServerController extends AbstractActionController
{

    public function mainAction()
    {

        /**
         * @var $console \Zend\Console\Adapter\Posix
         */
        $console = $this->getServiceLocator()->get('console');
        $width = $console->getWidth();
        $line = null;
        for ($increment = 1; $width >= $increment; $increment++) {
            $line .= '-';
        }
        $console->writeLine($line, Color::LIGHT_BLUE);
        $console->writeLine("Create service, command-line.", Color::LIGHT_GREEN);
        $console->writeLine($line, Color::LIGHT_BLUE);

        $this->start();



    }

    public function start(){
        $app = new RatchetApp('localhost', 8080);
        $app->route('/chat', new MyChat);
        $app->run();

//        $loop = \React\EventLoop\Factory::create();
//        $socket = new \React\Socket\Server($loop);
//        $socket->on('connection', function ($conn) {
//            echo 'Enviando mensagem...' . PHP_EOL;
//
//            $this->createJob();
//            echo 'Enviada' . PHP_EOL;
//        });
//        $socket->listen(8080);
//        $loop->run();
    }

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {



        foreach ($this->clients as $client) {


                // if ($from != $client) {
                echo "\n MSG => " . $msg;
                $client->send("Email enviado com sucesso!!");

            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    public function createJob()
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

class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {



        foreach ($this->clients as $client) {


                // if ($from != $client) {
                echo "\n MSG => " . $msg;
                $client->send("Email enviado com sucesso!!");

            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }


}