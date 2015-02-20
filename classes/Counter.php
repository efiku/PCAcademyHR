<?php

namespace PCAcademyHR;

use DateInterval;
use DateTime;
use PDO;
use PDOException;

/**
 * Class Counter
 * @package efikCounter
 *
 */
class Counter
{

    /**
     * INSTANCE OF OBJECT
     * @var Counter
     */
    private static $instance;


    /**
     * @var PDO
     */
    public $DBH;


    /**
     * CONSTRUCTOR
     *
     * @param $ConfigArray
     */
    public function  __construct(&$ConfigArray)
    {

        $dsn =
            'mysql:host=' . $ConfigArray['HOST'] .
            ';dbname=' . $ConfigArray['DBNAME'] .
            ';port=' . $ConfigArray['PORT'];

        $user = $ConfigArray['USER'];
        $password = $ConfigArray['PASS'];


        try {
            $this->DBH = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            die("Something goes wrong while connecting to database.\n" . $e->getMessage());
        }

    }


    /**
     * INITIALIZE OBJECT COUNTER
     *
     * @param $CONFIG
     * @return Counter
     */
    public static function getInstance(&$CONFIG)
    {
        if (!isset(self::$instance)) {
            self::$instance = new Counter($CONFIG);
        }
        return self::$instance;
    }


    /**
     * GET DATA BETWEEN RANGE
     * return array with Data in range
     * Parameters are not secured.
     *
     * @param $start
     * @param $end
     * @return array
     */
    public function getDataBetween($start, $end)
    {
        $sql = "SELECT `DATE`, `READ`  FROM ELECTRICITY_METER_READS WHERE ( `DATE` BETWEEN '$start' AND '$end')";
        $sql2 = "SELECT `DATE`, `READ`  FROM ELECTRICITY_METER_READS WHERE ( `DATE` = '$start' )";

        // if sql query is ok
        if ($db = $this->DBH->query($sql2)) {
            // if searched DATA not exists
            if ($db->fetchColumn() == 0) {

                $tab_a = $this->checkOneBeforeData($start);
                $tab_b = $this->fetchDbData($sql);

                // return range
                return array_merge($tab_a, $tab_b);
            } else {
                // return range
                return $this->fetchDbData($sql);
            }
        }
        return false;


    }


    /**
     * CHECK ONE DAY BEFORE
     * returns one day before range
     *
     * @param $data
     * @return array
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
        return ($keys > 0 ? $fetchedData : array());
    }


    /**
     * FETCH DATA FROM DATABASE
     * and store it in array as Associative Array.
     * like 'YYYY-NN-DD' => 'VALUE"
     *
     * @param $sql
     * @return array
     */
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


    public function array_truncate(array $array, $left, $right)
    {
        $array = array_slice($array, $left, count($array) - $left);
        $array = array_slice($array, 0, count($array) - $right);
        return $array;
    }

    /**
     * AVERAGE ENERGY CONSUMPTION
     *
     * return Average energy consumption for each day.
     *
     * <pre>
     *  $DATA = array(
     *        '2014-01-01' => 0.00,
     *        '2014-01-30' => 145.44 );
     * $cut = array ( '2014-01-08' , '2014-01-15' );
     *
     * print_r($counter->getAverageScores($DATA,$cut));
     *
     * </pre>
     * @param array $DATA
     * @param array $cut_between_date
     * @return array
     */
    public function getAverageScores(&$DATA = array(), &$cut_between_date = array())
    {
        /*
         *  This variable is returned when loop "for" is done.
         *  Yes, function return empty array if range from $cut_between_date is not exists
         *  in array from 1st parameter or $DATA isn't array! :)
        */
        $result_array = array();

        if (!is_array($DATA)) return $result_array;

        /*
         * In this variable is stored 1st parameter
         */
        $array_from_first_parameter = $DATA;

        /*
         *  Ok, trust me. Let's start!
         *
         * Count how many keys $array_from_first_parameter have.
         * And store this useful information to this variable.
         */
        $number_of_all_elements = count($array_from_first_parameter);


        /*
         * This variable stores only keys from $array_from_first_parameter
         * it's necessary, because I'm working on associative arrays ;-)
         */
        $array_of_keys = array_keys($array_from_first_parameter);


        /*
         * Sometimes keys can be not sorted ;-)
         *
         */
        sort($array_of_keys);


        /*
         *
         *  It's time for main loop!
         *  Whoaah!
         */
        for ($i = 0; $i < $number_of_all_elements - 1; $i++) {
            $data_between_start = new DateTime($array_of_keys[$i]);
            $data_between_end = new DateTime($array_of_keys[($i + 1)]);
            $temp_day = $data_between_start;

            // Troubles with Feb 29 or 28 ? NO MORE!
            $n_days_from_range = $data_between_start->diff($data_between_end)->days;

            // e.g 200  - 100 = 100.00
            $change_counter = $array_from_first_parameter[$array_of_keys[($i + 1)]] - $array_from_first_parameter[$array_of_keys[$i]];

            // Average energy from range 100 / x days
            $average_energy_f_range = ($change_counter / $n_days_from_range);


            // loop for fill missing data between $data_between_start and $data_between_end
            for ($k = 0; $k <= $n_days_from_range; $k++) {
                // fill $result_array with  received data
                // clever line of code!
                $result_array[$temp_day->format("Y-m-d")] = round($average_energy_f_range, 2);
                $temp_day->add(new DateInterval('P1D'));


            } //endfor

        } //endfor

        /*
         * Good time to check if data range in array $result_array
         * and work with it
         */
        $array_of_keys = array_keys($result_array);
        $number_of_all_elements = count($array_of_keys);
        $data_between_start = new DateTime($cut_between_date[0]);
        $data_between_end = new DateTime($cut_between_date[1]);

        for ($loop = 0; $loop < $number_of_all_elements; $loop++) {

            $current_data = new DateTime($array_of_keys[$loop]);

            if ($current_data >= $data_between_start && $current_data <= $data_between_end) {
                $new_result_array[$array_of_keys[$loop]] = $result_array[$array_of_keys[$loop]];
            }


        }

        $result_array = $new_result_array;

        return $result_array;
    }


}