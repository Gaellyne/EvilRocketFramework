<?php

include_once '../bootstrap.php';

class testAsterisk// extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        //echo 'aaa';
    }

    public function testConnection()
    {
        $asterisk = new Evil_Call_Asterisk();
        $asterisk->Call('89179273515', 'я тестирую астериск');
        return $asterisk;
    }

    public function testConn()
    {
        $server = '192.168.1.189';
        $user = 'admin';
        $pass = 'amp111';

        $oSocket = fsockopen($server, 5038, $errnum, $errdesc) or die("Connection to host failed");
        if (!$oSocket)
        {
            echo $errdesc . '(' . $errnum . '.)'. PHP_EOL;
        }
        else
        {
            echo 'conn ok', PHP_EOL;
            
            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Events: off\r\n");
            fputs($oSocket, "Username: " . $user ."\r\n");
            fputs($oSocket, "Secret: " . $pass ."\r\n\r\n");

            fputs($oSocket, "Action: Originate\r\n");
            fputs($oSocket, "Channel: LOCAL/89178962496@from-internal\r\n");
            fputs($oSocket, "WaitTime: 120\r\n");
            fputs($oSocket, "CallerId: open.kzn.ru\r\n");
            fputs($oSocket, "Exten: 1001\r\n");
            fputs($oSocket, "Context: from-internal\r\n");
            fputs($oSocket, "Priority: 1\r\n\r\n");
            fputs($oSocket, "Action: Logoff\r\n\r\n");
            while (!feof($oSocket)) {
                echo fgets($oSocket, 128);
            }
            fclose($oSocket);
        }

        var_dump('aaa');
    }
}


$a = new testAsterisk();
$a->testConn();