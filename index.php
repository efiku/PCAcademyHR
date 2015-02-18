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

$counter = Counter::getInstance($config);
    unset($config);

$loader = new Twig_Loader_Filesystem('./templates/');
$twig = new Twig_Environment($loader);

/**
 *
 *  Solution of task NR 1 :D
 *
 */
$a[0] = $counter->getDataBetween("2014-01-15", "2014-02-15");
$a[1] = $counter->getDataBetween("2014-03-03", "2014-05-15");
$a[2] = $counter->getDataBetween("2015-06-15", "2015-08-15");

echo $twig->render('index.twig', array(
    'TABA' => print_r($a[0], true),
    'TABB' => print_r($a[1], true),
    'TABC' => print_r($a[2], true)
));

