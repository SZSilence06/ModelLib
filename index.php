<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    
    require_once 'php/ModelLib.php';

    $server = new Server();
    $server->run();
?>