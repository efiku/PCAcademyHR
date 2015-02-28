<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof
 * Date: 2015-02-17
 */

require_once('config.php');
require('./classes/Counter.php');
require('./vendor/autoload.php');

use PCAcademyHR\Counter;

/*
 *
 *  initialize Counter
 *
 */
$counter = Counter::getInstance($config);
unset($config);


/*
 *
 * Twig
 *
 */
$loader = new Twig_Loader_Filesystem('./templates/');
$twig = new Twig_Environment($loader);

/*
 *
 * Header ->
 *
 */

echo $twig->render('header.twig');


/*
 *
 * Task NR 1 !!
 *
 *
 */
$data_array = Array('2014-01-01', '2014-03-31');


$result_to_first_task = $counter->getDataBetween($data_array[0], $data_array[1]);


echo $twig->render('zadanie_1.twig', array(
    'PA' => join(' do ', $data_array),
    'TABA' => print_r($result_to_first_task, true),
));


/*
 *
 *  Task NR 2 !!
 *
 *  2014 -> 02 -> 28 or  29?  No more!
 */
$cut_between = array('2014-01-28', '2014-03-10');
$result_to_second_task = $counter->getAverageScores($result_to_first_task, $cut_between);


echo $twig->render('zadanie_2.twig', array(
    'PA' => join(' < - > ', $cut_between),
    'TABA' => print_r($result_to_second_task, true)

));

/*
 *
 *  TASK NR 3 !!
 *  Im newbie in twig..
 */
$result_to_third_task = "";

foreach ($result_to_second_task as $DATA => $VAL) {
    $dd = explode("-", $DATA);
    $result_to_third_task .= "\n{ x: new Date(" . $dd[0] . ", " . (round($dd[1]) - 1) . ", " . round($dd[2]) . "), y: $VAL },\n";
}

echo $twig->render('fotter.twig', array(
    'PA' => join("\tDo\t", $cut_between),
    'DATA_POINTS' => $result_to_third_task

));