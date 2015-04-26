<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
// Make sure composer dependencies have been installed
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/module/Application/src/Application/Job/EmailJob.php';

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
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

            if($this->enviarEmail()) {
                // if ($from != $client) {
                echo "\n MSG => " . $msg;
                $client->send("Email enviado com sucesso!!");
            }
            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    public function enviarEmail(){


        $email = array(
            'name' => "Rororo"
        );
        $this->queue("default")->push("EmailJob",  $email);

        return true;
    }
}

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new MyChat);
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
$app->run();