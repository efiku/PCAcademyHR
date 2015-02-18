<?php

namespace PCAcademyHR;
use PDO;
use PDOException;

/**
 * Class Counter
 * @package efikCounter
 */
class Counter
{

    /**
     * @var
     */
    private static $instance;
    /**
     * @var PDO
     */
    public $DBH;

    /**
     * @param $ConfigArray
     */
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

    /**
     * @param $CONFIG
     * @return Counter
     */
    public static function getInstance(&$CONFIG)
    {
        if (!isset(self::$instance)){
            self::$instance = new Counter($CONFIG);
        }
        return self::$instance;
    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function getDataBetween($start, $end)
    {
        $sql    = "SELECT `DATE`, `READ`  FROM ELECTRICITY_METER_READS WHERE ( `DATE` BETWEEN '$start' AND '$end')";
        $sql2   = "SELECT `DATE`, `READ`  FROM ELECTRICITY_METER_READS WHERE ( `DATE` = '$start' )";


        if($db =  $this->DBH->query($sql2))
        {
            if ($db->fetchColumn() == 0) {

                $tab_a = $this->chceckOneBeforeData($start);
                $tab_b = $this->fetchDbData($sql);
                return array_merge($tab_a,$tab_b);
            }
            else{
                return $this->fetchDbData($sql);
            }
        }
        return false;




    }

    /**
     * @param $data
     * @return bool
     */
    public function chceckOneBeforeData($data)
    {
        $sql = "SELECT `DATE`, `READ`
                FROM ELECTRICITY_METER_READS
                WHERE (`DATE` < '$data')
                ORDER BY `DATE` DESC
                LIMIT 1";


        $fetchedData = $this->fetchDbData($sql);

        $keys = count($fetchedData);
        return ($keys > 0 ? $fetchedData : FALSE );
    }

    public function fetchDbData($sql)
    {
        $temp_res = array();
        $stm = $this->DBH->query($sql);

        if($stm == FALSE) { die("Error while fetching data");  }
        while ($row = $stm->fetch()) {

                $temp_res[$row['DATE']] = $row['READ'];

        }
        return $temp_res;
    }



} 