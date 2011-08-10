<?php

include_once '../bootstrap.php';

class testAsterisk extends PHPUnit_Framework_TestCase
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
        $server = '192.168.1.188';
        $port = "5038";
        $user = 'admin';
        $pass = 'amp111';
        $phone = "89179273515";

        $oSocket = fsockopen($server, $port, $errnum, $errdesc) or die("Connection to host failed");
        if (!$oSocket)
        {
            echo $errdesc . '(' . $errnum . '.)'. PHP_EOL;
        }
        else
        {
            echo 'conn ok', PHP_EOL;

            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Events: on\r\n");
            fputs($oSocket, "Username: " . $user ."\r\n");
            fputs($oSocket, "Secret: " . $pass ."\r\n\r\n");

          //  fputs($oSocket, "Action: ListCommands\r\n\r\n");
            

            fputs($oSocket, "Action: Originate\r\n");
            fputs($oSocket, "Channel: LOCAL/".$phone."@from-internal\r\n");
            fputs($oSocket, "Context: from-internal\r\n");
            fputs($oSocket, "Exten: 1001\r\n");
            fputs($oSocket, "WaitTime: 120\r\n");
            fputs($oSocket, "Timeout: 30000\r\n");
            fputs($oSocket, "CallerId: open.kzn.ru <89179666777>\r\n");
            fputs($oSocket, "Async: yes\r\n");
            fputs($oSocket, "Priority: 1\r\n\r\n");
            

            fputs($oSocket, "Action: Logoff\r\n\r\n");
            while (!feof($oSocket))
            {
                echo fgets($oSocket, 128);
            }
            fclose($oSocket);
        }

        var_dump('aaa');
    }
}

