<?php

namespace PCAcademyHR;

use DateTime;
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

                $tab_a = $this->checkOneBeforeData($start);
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
     * @return bool or Array
     */
    public function checkOneBeforeData($data)
    {
        $sql = 'SELECT `DATE`,`READ` ' .
            'FROM ELECTRICITY_METER_READS ' .
            "WHERE (`DATE` < '$data') " .
            'ORDER BY `DATE` DESC ' .
            'LIMIT 1';


        $fetchedData = $this->fetchDbData($sql);

        $keys = count($fetchedData);
        return ($keys > 0 ? $fetchedData : FALSE );
    }

    public function fetchDbData($sql)
    {
        $temp_res = array();
        $stm = $this->DBH->query($sql);

        if ($stm == FALSE) {
            die("You have an error in your SQL syntax:\n" . $sql);
        }
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

            $temp_res[$row['DATE']] = $row['READ'];

        }
        return $temp_res;
    }

    public function getbet($dd, $wytnij_od, $wytnij_do)
    {
        // tablica z poprzedniej funkcji
        $tablica_z_poprzedniej_funkcji = $dd;

        // zliczam ilosc wszystkich elementow
        $ilosc_wszystkich_el = count($tablica_z_poprzedniej_funkcji);


        // Tworze gotowa tablice
        $pokolei = array();

        $pobierz_klucze = (array_keys($tablica_z_poprzedniej_funkcji));

        sort($pobierz_klucze);

        $liczba_dni_z_przedzialu = 0;
        $srednia_energia_z_przedzialu = 0;


        for ($i = 0; $i < $ilosc_wszystkich_el - 1; $i++) {
            $tymczasowy_dzien = new DateTime();

            $data_prz_1 = new DateTime($pobierz_klucze[$i]);
            $data_prz_2 = new DateTime($pobierz_klucze[($i + 1)]);
            $tymczasowy_dzien = $data_prz_1;

            $liczba_dni_z_przedzialu = $data_prz_1->diff($data_prz_2)->days;


            $zmiana_licznika = $tablica_z_poprzedniej_funkcji[$pobierz_klucze[$i + 1]] - $tablica_z_poprzedniej_funkcji[$pobierz_klucze[$i]];


            $srednia_energia_z_przedzialu = (($zmiana_licznika) / $liczba_dni_z_przedzialu);


            for ($k = 0; $k <= $liczba_dni_z_przedzialu; $k++) {
                $pokolei[$tymczasowy_dzien->format("y-m-d")] = round($srednia_energia_z_przedzialu, 2);
                $tymczasowy_dzien->add(new \DateInterval('P1D'));
            }

        }


        return $pokolei;
    }



} 