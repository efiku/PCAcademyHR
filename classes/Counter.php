<?php

namespace efikCounter;
use PDO;
use PDOException;

class Counter {

    public $DBH;
    private static $instance;

    public  function  __construct(&$ConfigArray)
    {

        // building data source name from config
        $dsn =
            'mysql:host='. $ConfigArray['HOST'] .
            ';dbname='. $ConfigArray['DBNAME'] .
            ';port='. $ConfigArray['PORT']
            ;

        // DB user
        $user = $ConfigArray['USER'];
        // DB password
        $password = $ConfigArray['PASS'];


        try{
            $this->DBH =  new PDO($dsn, $user, $password);
            unset($ConfigArray);
        }
        catch(PDOException $e)
        {
            die("Something goes wrong while connecting to database.\n". $e->getMessage());
        }

    }

    public static function getInstance(&$CONFIG)
    {
        if (!isset(self::$instance)){
            self::$instance = new Counter($CONFIG);
        }
        return self::$instance;
    }



} 